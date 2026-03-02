<?php

namespace App\Http\Controllers;

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

        Team::create([
            'name' => $request->name,
            'competition' => $request->competition,
            'house_id' => Auth::user()->house_id,
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

        $players = getPlayersByTeam($team);
        $crews = getCrewsByTeam($team);

        return view('teamdetail', compact('team', 'majorsForCurrentHouse', 'players', 'crews'));
    }

    public function addPlayer(Request $request, Team $team)
    {
        dd('addPlayer HIT');
        
        $validated = $request->validate([
            'name' => 'required',
            'nrp' => 'required|max:9',
            'major' => 'required',
            'ktm_photo' => 'required|image',
            'whatsapp' => 'required',
            'mobilelegend' => 'nullable'
        ]);

        $path = $request->file('ktm_photo')->store('ktm_photos', 'public');

        // Cari participant berdasarkan NRP supaya tidak duplikat
        $participant = Participant::firstOrCreate(
            ['nrp' => $validated['nrp']],
            [
                'name' => $validated['name'],
                'major' => $validated['major'],
                'ktm_photo' => $path,
                'whatsapp' => $validated['whatsapp'],
                'mobilelegend' => $team->competition == 'E-sport'
                    ? $validated['mobilelegend']
                    : null,
                'status' => 'Menunggu',
                'revision' => null
            ]
        );

        // Masukkan relasi ke pivot
        $team->participantTeams()->firstOrCreate([
            'participant_id' => $participant->id,
        ]);

        return redirect()->back()->with('success','Player berhasil ditambahkan');
    }
    
}
    
