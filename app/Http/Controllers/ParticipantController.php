<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Team;
use App\Models\ParticipantTeam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    public function addPlayer(Request $request, Team $team)
    {
        //dd($request->all());
        $nrp = $request->nrp;
        $nrpCount = Participant::where('nrp', $nrp)->count();

        if ($nrpCount > 0){
            return redirect()->back()
                    ->withErrors(['nrp' => 'NRP sudah didaftarkan sebelumnya'], 'addNewPlayer')
                    ->withInput();
        }        

        $validated = $request->validate([
            'name' => 'required',
            'nrp' => 'required|max:9|unique:participants,nrp',
            'major' => 'required',
            'ktm_photo' => 'required|image',
            'whatsapp' => 'required',
            'mobilelegend' => 'nullable',
            'backnumber' => 'nullable|integer|min:1|max:100'
        ]);
        
        $extension = $request->file('ktm_photo')->getClientOriginalExtension();
        $time = date('His_dmy');
        $filename = $validated['nrp'] . '_' . $time . '.' . $extension;
        $path = $request->file('ktm_photo')->storeAs(
            'ktm_photos',
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
            'status' => 'Menunggu',
            'revision' => null
        ]);

        $participant->teams()->attach($team->id, [
            'back_number' => $validated['backnumber'] ?? null,
        ]);

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

        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'backnumber' => 'nullable|integer|min:1|max:100'
        ]);

        $team->participants()->syncWithoutDetaching([
            $request->participant_id => [
                'back_number' => $request->backnumber
            ]
        ]);

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
                'ktm_photos',
                $filename,
                'public'
            );                
            $participant->ktm_photo = $path;
        }        

        // Update field biasa
        $participant->name = $request->name;
        $participant->nrp = $request->nrp;
        $participant->major = $request->major;
        $participant->whatsapp = $request->whatsapp;
        $participant->mobilelegend = $request->mobilelegend;
        $team->participants()->updateExistingPivot($playerId, [
            'back_number' => $request->backnumber
        ]);
        $participant->save();

        return redirect()->back()->with('success', 'Player berhasil diupdate');
    }

    public function updateStatus(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        // Update status sesuai pilihan dropdown
        $participant->status = $request->status;

        // Cek jika status yang dipilih adalah "Diterima"
        if ($request->status === 'Diterima') {
            $participant->revision = null; // Kosongkan notes revisi
        }

        $participant->save();

        return redirect()->back()->with('success', 'Status berhasil diupdate');
    }

    public function updateRevision(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:participants,id',
            'revision' => 'nullable|string'
        ]);

        $participant = Participant::findOrFail($validated['id']);

        $participant->revision = $validated['revision'];
        $participant->save();

        // UBAH BAGIAN INI: Tambahkan with('success', 'pesan...')
        return redirect()->back()->with('success', 'Revision notes berhasil disimpan');
    }
}