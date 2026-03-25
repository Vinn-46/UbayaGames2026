<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Team;
use App\Models\CrewTeam;
use App\Models\Crew;
use App\Models\ParticipantTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    public function addPlayer(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required',
            'nrp' => 'required|max:9|unique:participants,nrp',
            'major' => 'required',
            'ktm_photo' => 'required|image',
            'whatsapp' => 'required',
            'mobilelegend' => 'nullable',
            'backnumber' => 'nullable|integer|min:1|max:100'
        ]);
        $nrp = $request->nrp;
        $crew = Crew::where('nrp', $nrp)->first(); 
        $crewCount = CrewTeam::where('crew_id', $crew->id ?? 0)
                             ->where('team_id', $team->id)
                             ->count();              
        if ($crewCount > 0){
            return redirect()->back()
                    ->withErrors(['crewExist' => 'Orang ini telah didaftarkan sebagai Crew di tim ini'], 'addNewPlayer')
                    ->withInput();
        }    
        $nrpCount = Participant::where('nrp', $nrp)->count();          
        if ($nrpCount > 0){
            return redirect()->back()
                    ->withErrors(['nrp' => 'NRP sudah didaftarkan sebelumnya'], 'addNewPlayer')
                    ->withInput();
        }   
        $competition=$team->competition;
        if (in_array($competition, ['Futsal', 'Basket Putra', 'Basket Putri', 'Voli Putra', 'Voli Putri'])) 
            {
                $backNumberCount = ParticipantTeam::where('team_id', $team->id)
                                    ->where('back_number', $request->backnumber)
                                    ->count();
                if ($backNumberCount > 0) {
                    return redirect()->back()
                    ->withErrors(['participant' => 'Nomor punggung telah didaftarkan di tim ini'], 'addNewPlayer')
                    ->withInput();
                } 
            }   
        $extension = $request->file('ktm_photo')->getClientOriginalExtension();
        $time = date('His_dmy');
        $filename = $validated['nrp'] . '_' . $time . '.' . $extension;
        $path = $request->file('ktm_photo')->storeAs(
            'ktm_photos_participants',
            $filename,
            'public'
        );       
        $participant = Participant::create([
            'house_id' => Auth::user()->house_id,
            'name' => $validated['name'],
            'nrp' => $validated['nrp'],
            'major' => $validated['major'],
            'ktm_photo' => $path,
            'whatsapp' => $validated['whatsapp'],
            'mobilelegend' => $team->competition == 'E-sport'
                ? $validated['mobilelegend']
                : null,
        ]);
                
        $participant->teams()->attach($team->id, [
            'back_number' => $validated['backnumber'] ?? null  ,       
            'status' => 'Menunggu',
            'revision' => null
        ]);
        $team->status = 'Menunggu';        
        $team->save();
        return redirect()->back()->with('success','Player berhasil ditambahkan');
    }

    public function attachExistingPlayer(Request $request, Team $team)
    {
        $teamId = $team->id;
        $participantId = $request->participant_id;

        $count = ParticipantTeam::where('participant_id', $participantId)
                                    ->where('team_id', $teamId)
                                    ->count();
        if ($count > 0) {
            return redirect()->back()
                    ->withErrors(['participant' => 'Pemain telah didaftarkan di tim ini'], 'addExistingPlayer')
                    ->withInput();
        } 
        $competition=$team->competition;
        if (in_array($competition, ['Futsal', 'Basket Putra', 'Basket Putri', 'Voli Putra', 'Voli Putri'])) 
            {
                $backNumberCount = ParticipantTeam::where('team_id', $teamId)
                                    ->where('back_number', $request->backnumber)
                                    ->count();
                if ($backNumberCount > 0) {
                    return redirect()->back()
                            ->withErrors(['backnumber' => 'Nomor punggung telah didaftarkan di tim ini'], 'addExistingPlayer')
                            ->withInput();
                }  
            }         
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'backnumber' => 'nullable|integer|min:1|max:100'
        ]);                                   
        $team->participants()->syncWithoutDetaching([
            $request->participant_id => [
                'back_number' => $request->backnumber,               
                'status' => 'Menunggu',
                'revision' => null
            ]
        ]);
        $team->status = 'Menunggu';
        $team->save();
        return redirect()->back()->with('success', 'Player berhasil ditambahkan ke team');
    }

    public function update(Request $request, $teamId, $playerId)
    {
        $validated = $request->validate([
            'name' => 'required',
            'nrp' => 'required|max:9|unique:participants,nrp,' . $playerId . ',id',
            'major' => 'required',
            'ktm_photo' => 'nullable|image',
            'whatsapp' => 'required',
            'backnumber' => 'nullable',
            'mobilelegend' => 'nullable'
        ]);

        $team = Team::findOrFail($teamId);
        $participant = Participant::findOrFail($playerId);        
        $competition = $team->competition;
        // Jika upload foto baru
        if ($request->hasFile('ktm_photo')) {

            // Hapus lama kalau ada
            if ($participant->ktm_photo) {
                Storage::disk('public')->delete($participant->ktm_photo);
            }
            $extension = $request->file('ktm_photo')->getClientOriginalExtension();
            $time = date('His_dmy');
            $filename = $validated['nrp'] . '_' . $time . '.' . $extension;

            $path = $request->file('ktm_photo')->storeAs(
                'ktm_photos_participants',
                $filename,
                'public'
            );                
            $participant->ktm_photo = $path;
        }        
        if (in_array($competition, ['Futsal', 'Basket Putra', 'Basket Putri', 'Voli Putra', 'Voli Putri']))  
            {
                $backNumberCount = ParticipantTeam::where('team_id', $teamId)
                                    ->where('back_number', $validated['backnumber'])
                                    ->where('participant_id', '!=', $playerId)
                                    ->count();

                if ($backNumberCount > 0) {
                return redirect()->back()
                        ->withErrors(['backnumber' => 'Nomor punggung telah didaftarkan di tim ini'], 'playerEdit')
                        ->withInput()
                        ->with('player_id', $playerId);
                }  
                $team->participants()->updateExistingPivot($playerId, [
                    'back_number' => $request->backnumber
                ]);
            }               
        
        // Update field biasa
        $participant->name = $request->name;
        $participant->nrp = $request->nrp;
        $participant->major = $request->major;
        $participant->whatsapp = $request->whatsapp;
        $participant->mobilelegend = $request->mobilelegend;       
        
        $participant->save();
        return redirect()->back()->with('success', 'Player berhasil diupdate');
    }

    public function updateStatus(Request $request, $participantId, $teamId)
    {
        $participant = Participant::findOrFail($participantId);
        
        // Ambil nilai baru
        $status = $request->status;
        $revision = ($status === 'Diterima') ? null : ($participant->pivot?->revision);
        // Update pivot
        $participant->teams()->updateExistingPivot($teamId, [
            'status' => $status,
            'revision' => $revision,
        ]);

        return redirect()->back()->with('success', 'Status player berhasil diupdate');
    }

    public function updateRevision(Request $request, $participantId, $teamId)
    {     
        $participant = Participant::findOrFail($participantId);
        $revision = $request->revision;

        // Update pivot
        $participant->teams()->updateExistingPivot($teamId, [            
            'revision' => $revision,
        ]);

        // UBAH BAGIAN INI: Tambahkan with('success', 'pesan...')
        return redirect()->back()->with('success', 'Revision notes player berhasil disimpan');
    }

    public function allplayer()
    {
        $user = Auth::user();
        $players = \App\Models\Participant::with('teams')
                        ->where('house_id', $user->house_id)
                        ->get();
                        
        return view('allplayer', compact('players'));
    }
}