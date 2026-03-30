<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\CrewTeam;
use App\Models\Team;
use App\Models\House;
use App\Models\Participant;
use App\Models\ParticipantTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    public function addCrew(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name'      => 'required',
            'whatsapp'  => 'required',
            'nrp'       => 'nullable',
            'major'     => 'nullable',
            'ktm_photo' => 'nullable|image',
            'role'      => 'required'
        ]);
        $nrp = $validated['nrp'] ?? null;
        $teamId = $team->id;
        $role = $validated['role'];
        $name = $validated['name'];
        $crew = Crew::where('name', $name)->firstOrFail();
        if ($crew){
            $crewCount = CrewTeam::where('crew_id', $crew->id)
                                    ->where('team_id', $teamId)
                                    ->count();
            if ($crewCount > 0){
                return redirect()->back()
                    ->withErrors(['crew' => 'Crew telah didaftarkan di tim ini'], 'addNewCrew')
                    ->withInput();
            }            
        }        
        if ($nrp) {            
            $player = Participant::where('nrp', $nrp)->first();

            if ($player) {
                $exists = ParticipantTeam::where('participant_id', $player->id)
                            ->where('team_id', $teamId)
                            ->exists();

                if ($exists) {
                    return redirect()->back()
                            ->withErrors(['playerExist' => 'Orang ini sudah jadi pemain di tim ini'], 'addNewCrew')
                            ->withInput();
                }
            }
        }   
        if (Crew::where('nrp', $nrp)->exists()){
            return redirect()->back()
                    ->withErrors(['nrp' => 'NRP sudah didaftarkan sebelumnya'], 'addNewCrew')
                    ->withInput();
        }           
        $roleExists = CrewTeam::where('team_id', $teamId)
                    ->where('role', $role)
                    ->exists();
        if ($roleExists) {
            return redirect()->back()
                    ->withErrors(['role' => "Tim ini telah memiliki $role"], 'addNewCrew')
                    ->withInput();
        }
        
        $path = null;
        if ($request->hasFile('ktm_photo')) {
            $extension = $request->file('ktm_photo')->getClientOriginalExtension();
            $time = date('His_dmy');
            $filename = $nrp . '_' . $time . '.' . $extension;
            $path = $request->file('ktm_photo')->storeAs(
                'ktm_photos_crews',
                $filename,
                'public'
            );  
        }
        // CREATE CREW
        $crew = Crew::create([
            'name'      => $validated['name'],
            'whatsapp'  => $validated['whatsapp'],
            'nrp'       => $nrp,
            'major'     => $validated['major'] ?? null,
            'ktm_photo' => $path,
            'house_id'  => Auth::user()->house_id
        ]);
        // ATTACH KE TEAM
        $crew->teams()->attach($teamId, [
            'role'     => $role,
            'status'   => 'Menunggu',
            'revision' => null,
        ]);       
        $team->status = 'Menunggu';        
        $team->save();
        return redirect()->back()
            ->with('success', 'Crew berhasil ditambahkan')
            ->with('openExistingCrewModal', true);
    }

    public function attachCrew(Request $request, Team $team)
    {
        $validated = $request->validate([
            'crew_id' => 'required',
            'role'    => 'required'
        ]);
        $role = $validated['role'];
        $teamId = $team->id;
        $crewId = $request->crew_id;
        $crew = Crew::find($crewId);
        $nrp = $crew ? $crew->nrp : null;
        if ($nrp) {            
            $player = Participant::where('nrp', $nrp)->first();

            if ($player) {
                $exists = ParticipantTeam::where('participant_id', $player->id)
                            ->where('team_id', $teamId)
                            ->exists();

                if ($exists) {
                    return redirect()->back()
                            ->withErrors(['playerExist' => 'Orang ini sudah jadi pemain di tim ini'], 'addExistingCrew')
                            ->withInput();
                }
            }
        }   
        $count = CrewTeam::where('crew_id', $crewId)
                                ->where('team_id', $teamId)
                                ->count();
        if ($count > 0){
            return redirect()->back()
                    ->withErrors(['crew' => 'Crew telah didaftarkan di tim ini'], 'addExistingCrew')
                    ->withInput();
        }
        $roleExists = CrewTeam::where('team_id', $teamId)
                    ->where('role', $role)
                    ->exists();
        if ($roleExists) {
            return redirect()->back()
                    ->withErrors(['role' => "Tim ini telah memiliki $role"], 'addExistingCrew')
                    ->withInput();
        }
        CrewTeam::create([
            'crew_id' => $request->crew_id,
            'team_id' => $team->id,
            'role'    => $request->role,
            'status'    => 'Menunggu',
            'revision'  => null,
        ]);
        $team->status = 'Menunggu';        
        $team->save();
        return redirect()->back()->with('success', 'Crew berhasil ditambahkan');
    }

    public function destroyCrew($teamId, $crewId)
    {
        $crewTeam = CrewTeam::where('team_id', $teamId)
                            ->where('crew_id', $crewId)
                            ->firstOrFail();
        $crewTeam->delete();

        return redirect()->back()->with('success', 'Crew berhasil dihapus.');
    }

    public function updateCrew(Request $request, $teamId, $crewId)
    {
        $validated = $request->validate([
            'name'      => 'required',
            'whatsapp'  => 'required',
            'role'      => 'required',
            'nrp'       => 'nullable',
            'major'     => 'nullable',
            'ktm_photo' => 'nullable|image',
        ]);
        $nrp = $validated['nrp'] ?? null;
        if (Crew::where('nrp', $nrp)->exists()){
            return redirect()->back()
                    ->withErrors(['nrp' => 'NRP sudah didaftarkan sebelumnya'], 'crewEdit')
                    ->withInput()
                    ->with('editCrewId', $crewId);
        }  
        $role = $validated['role'];
        $roleExists = CrewTeam::where('team_id', $teamId)
                    ->where('role', $role)
                    ->exists();
        if ($roleExists) {
            return redirect()->back()
                    ->withErrors(['role' => "Tim ini telah memiliki $role"], 'crewEdit')
                    ->withInput()
                    ->with('editCrewId', $crewId);
        }
        $crewTeam = CrewTeam::where('team_id', $teamId)
                            ->where('crew_id', $crewId)
                            ->firstOrFail();
        $crewTeam->update(['role' => $request->role]);

        $crew = Crew::findOrFail($crewTeam->crew_id);
        $crew->name     = $request->name;
        $crew->whatsapp = $request->whatsapp;
        $crew->nrp      = $request->nrp;
        $crew->major    = $request->major;

        // Jika upload foto baru
        if ($request->hasFile('ktm_photo')) {

            // Hapus lama kalau ada
            if ($crew->ktm_photo) {
                Storage::disk('public')->delete($crew->ktm_photo);
            }
            $extension = $request->file('ktm_photo')->getClientOriginalExtension();
            $time = date('His_dmy');
            $filename = $request->nrp . '_' . $time . '.' . $extension;

            $path = $request->file('ktm_photo')->storeAs(
                'ktm_photos_crews',
                $filename,
                'public'
            );                
            $crew->ktm_photo = $path;
        }       
        
        $crew->save();

        return redirect()->back()->with('success', 'Crew berhasil diupdate.');
    }
    public function updateGeneralCrew(Request $request, $crewId)
    {
        $validated = $request->validate([
            'name'      => 'required',
            'whatsapp'  => 'required',
            'nrp'       => 'nullable',
            'major'     => 'nullable',
            'ktm_photo' => 'nullable|image',
        ]);
        $nrp = $validated['nrp'] ?? null;
        if (Crew::where('nrp', $nrp)->exists()){
            return redirect()->back()
                    ->withErrors(['nrp' => 'NRP sudah didaftarkan sebelumnya'], 'crewEdit')
                    ->withInput()
                    ->with('editCrewId', $crewId);
        }  
        
        $crew = Crew::findOrFail($crewId);
        $crew->name     = $request->name;
        $crew->whatsapp = $request->whatsapp;
        $crew->nrp      = $request->nrp;
        $crew->major    = $request->major;

        // Jika upload foto baru
        if ($request->hasFile('ktm_photo')) {

            // Hapus lama kalau ada
            if ($crew->ktm_photo) {
                Storage::disk('public')->delete($crew->ktm_photo);
            }
            $extension = $request->file('ktm_photo')->getClientOriginalExtension();
            $time = date('His_dmy');
            $filename = $request->nrp . '_' . $time . '.' . $extension;

            $path = $request->file('ktm_photo')->storeAs(
                'ktm_photos_crews',
                $filename,
                'public'
            );                
            $crew->ktm_photo = $path;
        }       
        
        $crew->save();

        return redirect()->back()->with('success', 'Crew berhasil diupdate.');
    }
    public function updateStatus(Request $request, $crewId, $teamId)
    {
        $crew = Crew::findOrFail($crewId);
        $status = $request->status;
        $revision = ($status === 'Diterima') ? null : ($crew->pivot?->revision);
        $crew->teams()->updateExistingPivot($teamId, [
            'status' => $status,
            'revision' => $revision,
        ]);
        return redirect()->back()->with('success', 'Status crew berhasil diupdate');
    }

    public function updateRevision(Request $request, $crewId, $teamId)
    {
        $crew = Crew::findOrFail($crewId);
        $revision = $request->revision;
        // Update pivot
        $crew->teams()->updateExistingPivot($teamId, [            
            'revision' => $revision,
        ]);

        return redirect()->back()->with('success', 'Revision notes crew berhasil disimpan');
    }

    public function allCrews()
    {
        $user = Auth::user();
        $crews = Crew::with('teams')
                    ->where('house_id', $user->house_id)
                    ->get();
        $houseName = House::where('id', $user->house_id)->value('name');
        $majorsForCurrentHouse = getMajorsByHouse($houseName);                
        return view('allcrew', compact('crews', 'majorsForCurrentHouse'));
    }

    public function destroy($id)
    {
        $crew = Crew::find($id);
        if ($crew) {
            $crew->teams()->detach();
            if ($crew->ktm_photo) {
                Storage::disk('public')->delete($crew->ktm_photo);
            }
            $crew->delete();
            return redirect()->back()->with('success', 'Data crew berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Crew tidak ditemukan');
    }
}