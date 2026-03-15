<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\CrewTeam;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    public function addCrew(Request $request, Team $team)
    {

        $request->validate([
            'name' => 'required',
            'whatsapp' => 'required',
            'nrp' => 'nullable',
            'major' => 'nullable',
            'ktm_photo' => 'nullable',
            'team_id' => 'required',
        ]);

        $ktmPath = null;

        if ($request->hasFile('ktm_photo')) {
        $ktmPath = $request->file('ktm_photo')->store('ktm_photos', 'public');
}

        // create crew
        $crew = Crew::create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'nrp' => $request->nrp,
            'major' => $request->major,
            'ktm_photo' => $ktmPath,
            'status' => 'Menunggu',
            'revision' => null,
            'house_id' => Auth::user()->house_id
        ]);

        return redirect()->back()
            ->with('success','Crew berhasil ditambahkan')
            ->with('openExistingCrewModal', true);
    }

    public function attachCrew(Request $request, Team $team)
{
    $request->validate([
        'crew_id' => 'required',
        'role' => 'required'
    ]);

    CrewTeam::create([
        'crew_id' => $request->crew_id,
        'team_id' => $team->id,
        'role' => $request->role
    ]);

    return redirect()->back()->with('success','Crew added to team');
}
}
