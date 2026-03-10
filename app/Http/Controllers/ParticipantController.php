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
            'mobilelegend' => 'nullable'
        ]);

        $path = $request->file('ktm_photo')->store('ktm_photos', 'public');

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

        $team->participantTeams()->create([
            'participant_id' => $participant->id,
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
            'participant_id' => 'required|exists:participants,id'
        ]);

        $team->participants()->syncWithoutDetaching([
            $request->participant_id
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
            'mobilelegend' => 'nullable'
        ]);

        $participant = Participant::findOrFail($playerId);

        // Jika upload foto baru
        if ($request->hasFile('ktm_photo')) {

            // Hapus lama kalau ada
            if ($participant->ktm_photo) {
                Storage::disk('public')->delete($participant->ktm_photo);
            }
            $path = $request->file('ktm_photo')->store('ktm_photos', 'public');
            $participant->ktm_photo = $path;
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