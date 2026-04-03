<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\CrewTeam;
use App\Models\Participant;
use App\Models\Team;
use App\Models\ParticipantTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $houseId = Auth::user()->house_id;

        $teams = Team::where('house_id', $houseId)->get();

        return view('teamlist', compact('teams'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'competition' => 'required'
        ]);

        $user = Auth::user();
        $houseId = $user->house_id;
        
        // Ambil nama house asli dari database
        $rawHouseName = $user->house ? $user->house->name : 'Tim Admin';
        
        // POTONG KATA "House of " DARI NAMA (Contoh: "House of Fortis" -> "Fortis")
        $houseName = trim(str_replace('House of ', '', $rawHouseName)); 

        $inputCompetition = $request->competition;

        // 1. Logika Pintar Penentuan Nama Tim & Cablom
        if ($inputCompetition === 'E-sport 1') {
            $actualCompetition = 'E-sport';
            $teamName = $houseName . ' 1';     // Hasil: "Fortis 1"
        } elseif ($inputCompetition === 'E-sport 2') {
            $actualCompetition = 'E-sport';
            $teamName = $houseName . ' 2';     // Hasil: "Fortis 2"
        } else {
            $actualCompetition = $inputCompetition;
            $teamName = $houseName;            // Hasil: "Fortis"
        }

        // 2. Validasi Duplikat (Mencegah tim mendaftar lomba yang sama 2x)
        if ($actualCompetition === 'E-sport') {
            $exists = Team::where('house_id', $houseId)->where('name', $teamName)->exists();
            if ($exists) {
                return redirect()->back()
                    ->withErrors(['competition' => "Tim E-Sports $teamName sudah terdaftar!"])
                    ->withInput();
            }
        } else {
            $exists = Team::where('house_id', $houseId)->where('competition', $actualCompetition)->exists();
            if ($exists) {
                return redirect()->back()
                    ->withErrors(['competition' => "Tim $actualCompetition sudah terdaftar!"])
                    ->withInput();
            }
        }

        // 3. Simpan ke Database
        Team::create([
            'name' => $teamName,
            'competition' => $actualCompetition,
            'house_id' => $houseId,
            'status' => 'Menunggu',
            'revision' => null
        ]);

        return redirect()->back()->with('success', "Team $teamName berhasil ditambahkan");
    }

    public function show(Request $request)
    {
        $id = $request->id;

        $team = Team::with([
            'participantTeams.participant',
            'crewTeams.crew'
        ])->findOrFail($id);

        $majorsForCurrentHouse = getMajorsByHouse($team->house->name);

        $houseParticipants = Participant::where('house_id', Auth::user()->house_id)->get();

        $houseCrews = Crew::where('house_id', Auth::user()->house_id)->get();
        
        $players = $team->participants()
            ->with('teams')
            ->orderBy('role', 'asc')
            ->get();
        $crews = $team->crews()
            ->with('teams')
            ->orderByRaw("FIELD(role, 'Koorcab', 'Coach', 'Assistant Coach', 'Medic')")
            ->get();

        return view('teamdetail', compact(
            'team',
            'majorsForCurrentHouse',
            'players',
            'crews',
            'houseParticipants',
            'houseCrews'
        ));
    }   
    public function changeName(Request $request, Team $team)
    {
        $currentName = $team->name;
        $newName = $request->newTeamName;
        //jika nama sama sebelumnya
        if ($currentName === $newName) {
            return redirect()->back()
                    ->withErrors(['sameName' => 'Nama tim tidak boleh sama dengan sebelumnya'], 'changeTeamName')
                    ->withInput();
        } 
        //aturan nama unik
        if (Team::where('name', $newName)->exists()) {
            return redirect()->back()
                    ->withErrors(['nameExist' => 'Nama tim sudah ada'], 'changeTeamName')
                    ->withInput();
        } 
        $team->update([
            'name' => $newName
        ]);
        return redirect()->back()->with('success', 'Nama tim berhasil diganti');
    }
    public function destroyPlayer(Team $team, Participant $participant)
    {
        $team->participants()->detach($participant->id);
        $team->status = 'Menunggu';
        $team->save();
        return redirect()->back()->with('success', 'Player berhasil dihapus dari tim');
    }
    public function deleteTeam($id)
    {
        $team = Team::findOrFail($id);

        // Hapus semua relasi di pivot table
        $team->participants()->detach();
        $team->crews()->detach();

        // Hapus team
        $team->delete();

        return redirect()->back()->with('success', 'Team berhasil dihapus');
    }

    # POV Sekretaris
    public function indexSekre(Request $request)
    {
        $query = Team::with('house');

        if ($request->filled('filter_by') && $request->filled('search')) {
            $filterBy = $request->filter_by;
            $search   = $request->search;

            if ($filterBy === 'status') {
                $query->where('status', $search);
            } elseif ($filterBy === 'competition') {
                $query->where('competition', $search);
            } elseif ($filterBy === 'house') {
                $query->whereHas('house', function ($q) use ($search) {
                    $q->where('name', $search);
                });
            }
        }

        $teams = $query->get();
        return view('teamlist_sekre', compact('teams'));
    }
    public function updateRevision(Request $request)
    {
        $request->validate([
            'team_id' => 'required',
            'revision' => 'nullable|string']);
        $team = Team::findOrFail($request->team_id);
        $team->revision = $request->revision;
        $team->save();
        return redirect()->back()->with('success','Revision berhasil disimpan');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Ditolak,Diterima']);
        $team = Team::findOrFail($id);
        $status = $request->status;
        $competition = $team->competition;
        if ($status === 'Diterima'){ //kalu diterima cek dulu jumlah minimum 
            $participantTeam = ParticipantTeam::where('team_id', $team->id)->get();
            $playerCount = $participantTeam->count();
            $utamaCount  = $participantTeam->where('role', 'Utama')->count();
            $rulesPlayer = [
                'Basket Putra' => ['minPlayer' => 7, 'minUtama' => 5],
                'Basket Putri' => ['minPlayer' => 7, 'minUtama' => 5],
                'Futsal Putra' => ['minPlayer' => 7, 'minUtama' => 5],
                'Voli Putra' => ['minPlayer' => 8, 'minUtama' => 6],
                'Badminton Ganda Putra' => ['minPlayer' => 2, 'minUtama' => 2],
                'Badminton Tunggal Putra' => ['minPlayer' => 1, 'minUtama' => 1],
                'Badminton Ganda Campuran' => ['minPlayer' => 2, 'minUtama' => 2],
                'E-sport' => ['minPlayer' => 5, 'minUtama' => 5],
                'Poster' => ['minPlayer' => 1, 'minUtama' => 1],
                'Lukis' => ['minPlayer' => 1, 'minUtama' => 1],
                'Dance' => ['minPlayer' => 2, 'minUtama' => 2],
                'Fotografi' => ['minPlayer' => 1, 'minUtama' => 1],
            ];            
            $minPlayer = $rulesPlayer[$competition]['minPlayer'];
            $minUtama  = $rulesPlayer[$competition]['minUtama'];
            if ($playerCount < $minPlayer) {
                return back()->withErrors([
                    'playerCount' => "Jumlah minimal pemain di $competition adalah $minPlayer orang"
                ], 'updateStatus')->withInput();
            }
            if ($utamaCount < $minUtama) {
                return back()->withErrors([
                    'utamaCount' => "Jumlah minimal pemain utama di $competition adalah $minUtama orang"
                ], 'updateStatus')->withInput();
            }          
            $crewTeam = CrewTeam::where('team_id', $team->id)->get();

            $roles = $crewTeam->pluck('role');
            $needCoach = ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 
                        'Badminton Ganda Putra', 'Badminton Tunggal Putra', 
                        'Badminton Ganda Campuran', 'E-sport', 'Dance'];
            $needAssistant = ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 
                            'Badminton Ganda Putra', 'Badminton Tunggal Putra', 
                            'Badminton Ganda Campuran', 'Dance'];
            $needMedic = ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 
                        'Badminton Ganda Putra', 'Badminton Tunggal Putra', 
                        'Badminton Ganda Campuran', 'Dance'];
            if (!$roles->contains('Koorcab')) {
                return back()->withErrors([
                    'koorcab' => "Tim belum memiliki Koorcab"
                ], 'updateStatus')->withInput();
            }
            if (in_array($competition, $needCoach) && !$roles->contains('Coach')) {
                return back()->withErrors([
                    'coach' => "Tim belum memiliki Coach"
                ], 'updateStatus')->withInput();
            }
            if (in_array($competition, $needAssistant) && !$roles->contains('Assistant Coach')) {
                return back()->withErrors([
                    'asstCoach' => "Tim belum memiliki Assistant Coach"
                ], 'updateStatus')->withInput();
            }
            if (in_array($competition, $needMedic) && !$roles->contains('Medic')) {
                return back()->withErrors([
                    'medic' => "Tim belum memiliki Medic"
                ], 'updateStatus')->withInput();
            }

            $allPlayerAccepted = $participantTeam->every(function ($item) {
                return $item->status === 'Diterima';
            });
            $allCrewAccepted = $crewTeam->every(function ($item) {
                return $item->status === 'Diterima';
            });
            if (!$allPlayerAccepted) {
                return back()->withErrors(['playerAccept' => "Semua pemain belum diterima"], 'updateStatus')->withInput();
            }
            if (!$allCrewAccepted) {
                return back()->withErrors(['crewAccept' => "Semua crew belum diterima"], 'updateStatus')->withInput();
            }
            // kalau semua validasi lolos
            $team->revision = null;
        }
        $team->status = $status;
        $team->save();
        return back()->with('success','Status tim berhasil diupdate');    
    }

    public function showSekre(Request $request)
    {
        $id = $request->id;
        $team = Team::with([
            'participantTeams.participant',
            'crewTeams.crew',
            'house'
        ])->findOrFail($id);
        $players = $team->participants;
        $crews = $team->crews;
        // Bisa langsung pakai property karena sudah di-eager load via crewTeams.crew
        return view('teamdetail_sekre', compact(
            'team',
            'players',
            'crews'
        ));
    }

    
}