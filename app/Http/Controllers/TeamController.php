<?php

namespace App\Http\Controllers;

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

        return view('teamdetail', compact('team'));
    }
}