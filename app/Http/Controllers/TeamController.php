<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Participant;
use App\Models\Team;
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
            'name' => 'required|max:255',
            'competition' => 'required'
        ]);

        $houseId = Auth::user()->house_id;
        $competition = $request->competition;
        $teamName = $request->name;

        // Hitung jumlah tim dengan house dan kompetisi yang sama
        $existingCount = Team::where('house_id', $houseId)
                            ->where('competition', $competition)
                            ->count();

        // Aturan khusus E-sport
        if ($competition === 'E-sport') {
            if ($existingCount >= 2) {
                return redirect()->back()
                    ->withErrors(['competition' => 'E-sport maksimal 2 tim per kontingen'])
                    ->withInput();
            }
        } else {
            if ($existingCount >= 1) {
                return redirect()->back()
                    ->withErrors(['competition' => 'Kompetisi ini sudah memiliki tim untuk kontingen Anda'])
                    ->withInput();
            }
        }
        //aturan nama unik
        if (Team::where('name', $teamName)->exists()) {
            return redirect()->back()
                    ->withErrors(['name' => 'Nama tim sudah ada'])
                    ->withInput();
        }           

        // Jika lolos validasi
        Team::create([
            'name' => $request->name,
            'competition' => $competition,
            'house_id' => $houseId,
            'status' => 'Menunggu',
            'revision' => null
        ]);

        return redirect()->back()->with('success','Team berhasil ditambahkan');
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
        
        $players = $team->participants()->with('teams')->get();
        $crews = $team->crews()->with('teams')->get();

        return view('teamdetail', compact(
            'team',
            'majorsForCurrentHouse',
            'players',
            'crews',
            'houseParticipants',
            'houseCrews'
        ));
    }   

    public function destroyPlayer(Team $team, Participant $participant)
    {
        $team->participants()->detach($participant->id);

        return redirect()->back()->with('success', 'Player berhasil dihapus');
    }
    public function deleteTeam($id)
    {
        $team = Team::findOrFail($id);

        // Hapus semua relasi di pivot table
        $team->participants()->detach();

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
        $team->status = $request->status;
        $oldrevision = $team->revision;
        $team->revision = ($request->status === 'Diterima' ? null : $oldrevision);
        $team->save();
        return back()->with('success','Status berhasil diupdate');
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