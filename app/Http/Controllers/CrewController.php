<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\CrewTeam;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    public function addCrew(Request $request, Team $team)
    {
        $request->validate([
            'name'      => 'required',
            'whatsapp'  => 'required',
            'nrp'       => 'nullable',
            'major'     => 'nullable',
            'ktm_photo' => 'nullable',
        ]);

        $ktmPath = null;
        if ($request->hasFile('ktm_photo')) {
            $ktmPath = $request->file('ktm_photo')->store('ktm_photos', 'public');
        }

        Crew::create([
            'name'      => $request->name,
            'whatsapp'  => $request->whatsapp,
            'nrp'       => $request->nrp,
            'major'     => $request->major,
            'ktm_photo' => $ktmPath,
            'status'    => 'Menunggu',
            'revision'  => null,
            'house_id'  => Auth::user()->house_id
        ]);

        return redirect()->back()
            ->with('success', 'Crew berhasil ditambahkan')
            ->with('openExistingCrewModal', true);
    }

    public function attachCrew(Request $request, Team $team)
    {
        $request->validate([
            'crew_id' => 'required',
            'role'    => 'required'
        ]);

        CrewTeam::create([
            'crew_id' => $request->crew_id,
            'team_id' => $team->id,
            'role'    => $request->role
        ]);

        return redirect()->back()->with('success', 'Crew added to team');
    }

    public function destroyCrew($teamId, $crewId)
    {
        $crewTeam = CrewTeam::where('team_id', $teamId)
                            ->where('id', $crewId)
                            ->firstOrFail();
        $crewTeam->delete();

        return redirect()->back()->with('success', 'Crew berhasil dihapus.');
    }

    public function updateCrew(Request $request, $teamId, $crewId)
    {
        $request->validate([
            'name'      => 'required',
            'whatsapp'  => 'required',
            'role'      => 'required',
            'nrp'       => 'nullable',
            'major'     => 'nullable',
            'ktm_photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $crewTeam = CrewTeam::where('team_id', $teamId)
                            ->where('id', $crewId)
                            ->firstOrFail();
        $crewTeam->update(['role' => $request->role]);

        $crew = Crew::findOrFail($crewTeam->crew_id);
        $crew->name     = $request->name;
        $crew->whatsapp = $request->whatsapp;
        $crew->nrp      = $request->nrp;
        $crew->major    = $request->major;

        if ($request->hasFile('ktm_photo')) {
            if ($crew->ktm_photo) {
                Storage::disk('public')->delete($crew->ktm_photo);
            }
            $crew->ktm_photo = $request->file('ktm_photo')->store('ktm_photos', 'public');
        }

        $crew->save();

        return redirect()->back()->with('success', 'Crew berhasil diupdate.');
    }

    public function updateStatus(Request $request, $id)
    {
        $crew = Crew::findOrFail($id);
        $crew->status = $request->status;
        $crew->save();

        return redirect()->back()->with('success', 'Status crew diupdate.');
    }

    public function updateRevision(Request $request, $id)
    {
        $crew = Crew::findOrFail($id);
        $crew->revision = $request->revision;
        $crew->save();

        return redirect()->back()->with('success', 'Revision crew diupdate.');
    }
}