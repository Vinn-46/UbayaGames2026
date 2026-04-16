<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Team;
use App\Models\House;
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
        if (Auth::user()->role === 'Kontingen' && Auth::user()->house_id !== $team->house_id) { abort(404); }
        $validated = $request->validate([
            'name' => 'required',
            'nrp' => 'required',
            'major' => 'required',
            'birthdate' => 'required',
            'ktm_photo' => 'required',
            'whatsapp' => 'required',
            'mobilelegend' => 'nullable',
            'backnumber' => 'nullable|integer|min:1|max:100'
        ]);
        $nrp = $validated['nrp'];
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
        if (in_array($competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra'])) 
        {
            $backNumberCount = ParticipantTeam::where('team_id', $team->id)
                                ->where('back_number', $request->backnumber)
                                ->count();
            if ($backNumberCount > 0) {
                return redirect()->back()
                ->withErrors(['backnumber' => 'Nomor punggung telah didaftarkan di tim ini'], 'addNewPlayer')
                ->withInput();
            } 
        }   
        if ($competition === 'E-sport')
        {            
            $idCount = Participant::where('mobilelegend', $request->mobilelegend)->count ();
            if ($idCount > 0)
            {
                return redirect()->back()
                            ->withErrors(['idMlExist' => 'ID Mobile Legend telah didaftarkan untuk pemain lain'], 'addNewPlayer')
                            ->withInput();
            }
        }
        $role = ($request->role) ? $request->role : 'Utama';
        // cek jumlah utama
        if ($role === 'Utama')
        {
            $limitUtama = [
                'Basket Putra' => 5,
                'Basket Putri' => 5,
                'Futsal Putra' => 5,
                'Voli Putra' => 6,
                'Badminton Ganda Putra' => 2,
                'Badminton Tunggal Putra' => 1,
                'Badminton Ganda Campuran' => 2,
                'E-sport' => 5,
                'Poster' => 2,
                'Lukis' => 1,
                'Dance' => 7,
                'Fotografi' => 1,
            ];
            $utamaCount = ParticipantTeam::where('team_id', $team->id)
                            ->where('role', 'Utama')
                            ->count();
            if ($utamaCount >= $limitUtama[$competition]) 
            {
                return back()->withErrors([
                    'exceedUtama' => "Jumlah maksimal pemain utama di cabang lomba $competition adalah {$limitUtama[$competition]} orang"], 'addNewPlayer')
                    ->withInput();
            }
        }
        // cek jumlah cadangan
        if ($role === 'Cadangan')
        {            
            $limitCadangan = [
                'Basket Putra' => 10,
                'Basket Putri' => 10,
                'Futsal Putra' => 10,
                'Voli Putra' => 7,
                'E-sport' => 1,
            ];
            $cadanganCount = ParticipantTeam::where('team_id', $team->id)
                            ->where('role', 'Cadangan')
                            ->count();
            if (isset($limitCadangan[$competition]) && 
                $cadanganCount >= $limitCadangan[$competition]) 
            {
                return back()->withErrors([
                    'exceedCadangan' => "Jumlah maksimal pemain cadangan di $competition adalah {$limitCadangan[$competition]} orang"], 'addNewPlayer')
                    ->withInput();
            }
        }
        // Ambil ekstensi dan ubah ke huruf kecil agar konsisten
        $extension = strtolower($request->file('ktm_photo')->getClientOriginalExtension());

        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($extension, $allowedExtensions)) {
            return back()
                ->withErrors(['ktm' => "KTM harus dalam format foto (.jpg/.png)"], 'addNewPlayer')
                ->withInput();
        }
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
            'birthdate' => $validated['birthdate'],
            'ktm_photo' => $path,
            'whatsapp' => $validated['whatsapp'],
            'mobilelegend' => $team->competition == 'E-sport' ? $validated['mobilelegend'] : null,
        ]);        
        $participant->teams()->attach($team->id, [
            'back_number' => $validated['backnumber'] ?? null  ,       
            'status' => 'Menunggu',
            'revision' => null,
            'role' => $role
        ]);
        if ($team->status === 'Diterima')
        {
            $team->status = 'Menunggu';
        }        
        $team->save();
        return redirect()->back()->with('success','Player berhasil ditambahkan');
    }

    public function attachExistingPlayer(Request $request, Team $team)
    {
        if (Auth::user()->role === 'Kontingen' && Auth::user()->house_id !== $team->house_id) { abort(404); }
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
        $participant = Participant::find($participantId);
        $nrp = $participant ? $participant->nrp : null;
        $crew = Crew::where('nrp', $nrp)->first(); 
        $crewCount = CrewTeam::where('crew_id', $crew->id ?? 0)
                             ->where('team_id', $team->id)
                             ->count();              
        if ($crewCount > 0){
            return redirect()->back()
                    ->withErrors(['crewExist' => 'Orang ini telah didaftarkan sebagai Crew di tim ini'], 'addExistingPlayer')
                    ->withInput();
        }  
        $competition=$team->competition;
        if (in_array($competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra'])) 
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
        if ($competition === 'E-sport')
        {
            $esportCount = ParticipantTeam::where('participant_id', $participantId)
                ->whereHas('team', function ($q) {
                    $q->where('competition', 'E-sport');
                })
                ->count();
            if ($esportCount > 0)
            {
                return redirect()->back()
                            ->withErrors(['esport' => 'Pemain ini telah didaftarkan di tim E-sport lain'], 'addExistingPlayer')
                            ->withInput();
            }
            $idCount = Participant::where('mobilelegend', $request->mobilelegend)->count ();
            if ($idCount > 0)
            {
                return redirect()->back()
                            ->withErrors(['idMlExist' => 'ID Mobile Legend telah didaftarkan untuk pemain lain'], 'addExistingPlayer')
                            ->withInput();
            }
            $participant = Participant::findOrFail($participantId); 
            $participant->update([
                'mobilelegend' => $request->mobilelegend
            ]);
        }
        $role = $request->role;
        // cek jumlah utama
        if ($role === 'Utama')
        {
            $limitUtama = [
                'Basket Putra' => 5,
                'Basket Putri' => 5,
                'Futsal Putra' => 5,
                'Voli Putra' => 6,
                'Badminton Ganda Putra' => 2,
                'Badminton Tunggal Putra' => 1,
                'Badminton Ganda Campuran' => 2,
                'E-sport' => 5,
                'Poster' => 2,
                'Lukis' => 1,
                'Dance' => 7,
                'Fotografi' => 1,
            ];
            $utamaCount = ParticipantTeam::where('team_id', $team->id)
                            ->where('role', 'Utama')
                            ->count();
            if ($utamaCount >= $limitUtama[$competition]) 
            {
                return back()->withErrors([
                    'exceedUtama' => "Jumlah maksimal pemain utama di $competition adalah {$limitUtama[$competition]} orang"], 'addExistingPlayer')
                    ->withInput();
            }
        }
        // cek jumlah cadangan
        if ($role === 'Cadangan')
        {
            $limitCadangan = [
                'Basket Putra' => 10,
                'Basket Putri' => 10,
                'Futsal Putra' => 10,
                'Voli Putra' => 7,
                'E-sport' => 1,
            ];
            $cadanganCount = ParticipantTeam::where('team_id', $team->id)
                            ->where('role', 'Cadangan')
                            ->count();
            if (isset($limitCadangan[$competition]) && 
                $cadanganCount >= $limitCadangan[$competition]) 
            {
                return back()->withErrors([
                    'exceedCadangan' => "Jumlah maksimal pemain cadangan di $competition adalah {$limitCadangan[$competition]} orang"], 'addExistingPlayer')
                    ->withInput();
            }
        }                
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'backnumber' => 'nullable|integer|min:1|max:100'
        ]);       
        $noCadangan = ['Badminton Ganda Putra', 'Badminton Tunggal Putra', 'Badminton Ganda Campuran', 'Poster', 'Lukis', 'Dance', 'Fotografi'];
        $role = in_array($competition, $noCadangan) ? 'Utama': $request->role;                            
        $team->participants()->syncWithoutDetaching([
            $request->participant_id => [
                'back_number' => $request->backnumber ?? null,               
                'status' => 'Menunggu',
                'revision' => null,
                'role' => $role
            ]
        ]);
        if ($team->status === 'Diterima')
        {
            $team->status = 'Menunggu';
        }        
        $team->save();
        return redirect()->back()->with('success', 'Player berhasil ditambahkan ke team');
    }

    public function update(Request $request, $teamId, $playerId)
    {
        $validated = $request->validate([
            'name' => 'required',
            'nrp' => 'required',
            'major' => 'required',
            'birthdate' => 'required',
            'ktm_photo' => 'nullable',
            'whatsapp' => 'required',
            'backnumber' => 'nullable',
            'mobilelegend' => 'nullable'
        ]);
        $hasChanged = false;
        $nrp = $request->nrp;
        $nrpCount = Participant::where('nrp', $nrp)
                                ->where('id', '!=', $playerId)
                                ->count();          
        if ($nrpCount > 0){
            return redirect()->back()
                    ->withErrors(['nrp' => 'NRP sudah didaftarkan sebelumnya'], 'playerEdit')
                    ->withInput()
                    ->with('editPlayerId', $playerId);
        } 
        $team = Team::findOrFail($teamId);
        $participant = Participant::findOrFail($playerId);        
        $competition = $team->competition;
        // Jika upload foto baru
        if ($request->hasFile('ktm_photo')) {
            $hasChanged = true;
            // Hapus lama kalau ada
            if ($participant->ktm_photo) {
                Storage::disk('public')->delete($participant->ktm_photo);
            }
            // Ambil ekstensi dan ubah ke huruf kecil agar konsisten
            $extension = strtolower($request->file('ktm_photo')->getClientOriginalExtension());

            // Gunakan array untuk mengecek banyak format sekaligus
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($extension, $allowedExtensions)) {
                return back()
                    ->withErrors(['ktm' => "KTM harus dalam format foto (.jpg/.png)"], 'playerEdit')
                    ->withInput()->with('editPlayerId', $playerId);
            }
            $time = date('His_dmy');
            $filename = $validated['nrp'] . '_' . $time . '.' . $extension;

            $path = $request->file('ktm_photo')->storeAs(
                'ktm_photos_participants',
                $filename,
                'public'
            );                
            $participant->ktm_photo = $path; 
        }        
        if ($competition === 'E-sport')
        {            
            $idCount = Participant::where('mobilelegend', $request->mobilelegend)
                                    ->where('id', '!=', $playerId)
                                    ->count ();
            if ($idCount > 0)
            {
                return redirect()->back()
                            ->withErrors(['idMlExist' => 'ID Mobile Legend telah didaftarkan untuk pemain lain'], 'playerEdit')
                            ->withInput()
                            ->with('editPlayerId', $playerId);
            }
        }
        if (in_array($competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))  
            {
                $backNumberCount = ParticipantTeam::where('team_id', $teamId)
                                    ->where('back_number', $validated['backnumber'])
                                    ->where('participant_id', '!=', $playerId)
                                    ->count();

                if ($backNumberCount > 0) {
                return redirect()->back()
                        ->withErrors(['backnumber' => 'Nomor punggung telah didaftarkan di tim ini'], 'playerEdit')
                        ->withInput()
                        ->with('editPlayerId', $playerId);
                }  
                $currentBackNumber = ParticipantTeam::where('team_id', $teamId)
                    ->where('participant_id', $playerId)
                    ->value('back_number');

                $team->participants()->updateExistingPivot($playerId, ['back_number' => $request->backnumber]);              
            }               
        
        $role = $request->role ?? 'Utama';
        // cek jumlah utama
        if ($role === 'Utama')
        {
            $limitUtama = [
                'Basket Putra' => 5,
                'Basket Putri' => 5,
                'Futsal Putra' => 5,
                'Voli Putra' => 6,
                'Badminton Ganda Putra' => 2,
                'Badminton Tunggal Putra' => 1,
                'Badminton Ganda Campuran' => 2,
                'E-sport' => 5,
                'Poster' => 2,
                'Lukis' => 1,
                'Dance' => 7,
                'Fotografi' => 1,
            ];
            $utamaCount = ParticipantTeam::where('team_id', $team->id)
                            ->where('role', 'Utama')
                            ->where('participant_id', '!=', $playerId)
                            ->count();
            if ($utamaCount >= $limitUtama[$competition]) 
            {
                return back()->withErrors([
                    'exceedUtama' => "Jumlah maksimal pemain utama di $competition adalah {$limitUtama[$competition]} orang"], 'playerEdit')
                    ->withInput()
                    ->with('editPlayerId', $playerId);
            }
        }
        // cek jumlah cadangan
        if ($role === 'Cadangan')
        {
            $limitCadangan = [
                'Basket Putra' => 10,
                'Basket Putri' => 10,
                'Futsal Putra' => 10,
                'Voli Putra' => 7,
                'E-sport' => 1,
            ];
            $cadanganCount = ParticipantTeam::where('team_id', $team->id)
                            ->where('role', 'Cadangan')
                            ->where('participant_id', '!=', $playerId)
                            ->count();
            if (isset($limitCadangan[$competition]) && 
                $cadanganCount >= $limitCadangan[$competition]) 
            {
                return back()->withErrors([
                    'exceedCadangan' => "Jumlah maksimal pemain cadangan di $competition adalah {$limitCadangan[$competition]} orang"], 'playerEdit')
                    ->withInput()
                    ->with('editPlayerId', $playerId);
            }
        }           
        $team->participants()->updateExistingPivot($playerId, ['role' => $role]);
        
        // Update field biasa
        $participant->name = $request->name;
        $participant->nrp = $request->nrp;
        $participant->major = $request->major;
        $participant->birthdate = $request->birthdate;
        $participant->whatsapp = $request->whatsapp;
        $participant->mobilelegend = $request->mobilelegend ?: null;       
        
        if ($participant->isDirty()) {
            $hasChanged = true;
        }
        
        if ($hasChanged) {        
            $participant->save();  
            $pivotQuery = ParticipantTeam::where('participant_id', $playerId);
            $teamIds = $pivotQuery->pluck('team_id');
            $pivotQuery->update(['status' => 'Menunggu']);
            Team::whereIn('id', $teamIds)
                ->update(['status' => 'Menunggu']);                   
        }
        return redirect()->back()->with('success', 'Player berhasil diupdate');
    }
    public function updateGeneral(Request $request, $playerId)
    {
        $validated = $request->validate([
            'name' => 'required',
            'nrp' => 'required',
            'major' => 'required',
            'birthdate' => 'required',
            'ktm_photo' => 'nullable',
            'whatsapp' => 'required',
        ]);
        $hasChanged = false;
        $nrp = $request->nrp;
        $nrpExists = Participant::where('nrp', $nrp)
                ->where('id', '!=', $playerId)
                ->exists();
        if ($nrpExists){
            return redirect()->back()
                    ->withErrors(['nrp' => 'NRP sudah didaftarkan sebelumnya'], 'playerEdit')
                    ->withInput()
                    ->with('editPlayerId', $playerId);
        } 
        $participant = Participant::findOrFail($playerId);        
        // Jika upload foto baru
        if ($request->hasFile('ktm_photo')) {
            $hasChanged = true;
            // Hapus lama kalau ada
            if ($participant->ktm_photo) {
                Storage::disk('public')->delete($participant->ktm_photo);
            }
            // Ambil ekstensi dan ubah ke huruf kecil agar konsisten
            $extension = strtolower($request->file('ktm_photo')->getClientOriginalExtension());

            // Gunakan array untuk mengecek banyak format sekaligus
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($extension, $allowedExtensions)) {
                return back()
                    ->withErrors(['ktm' => "KTM harus dalam format foto (.jpg/.png)"], 'playerEdit')
                    ->withInput()->with('editPlayerId', $playerId);
            }
            $time = date('His_dmy');
            $filename = $validated['nrp'] . '_' . $time . '.' . $extension;

            $path = $request->file('ktm_photo')->storeAs(
                'ktm_photos_participants',
                $filename,
                'public'
            );                
            $participant->ktm_photo = $path; 
        }        
        // Update field biasa
        $participant->name = $request->name;
        $participant->nrp = $request->nrp;
        $participant->major = $request->major;
        $participant->birthdate = $request->birthdate;
        $participant->whatsapp = $request->whatsapp;      
        if ($participant->isDirty()) {
            $hasChanged = true;
        }
        if ($hasChanged) {            
            $participant->save();  
            $pivotQuery = ParticipantTeam::where('participant_id', $playerId);
            $teamIds = $pivotQuery->pluck('team_id');
            $pivotQuery->update(['status' => 'Menunggu']);
            Team::whereIn('id', $teamIds)
                ->update(['status' => 'Menunggu']);           
        }   
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
        if ($status === 'Menunggu' || $status === 'Ditolak') {
            Team::where('id', $teamId)->update(['status' => 'Menunggu']);
        }
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
        $players = Participant::with('teams')
                        ->where('house_id', $user->house_id)
                        ->get();
        $houseName = House::where('id', $user->house_id)->value('name');
        $majorsForCurrentHouse = getMajorsByHouse($houseName);                
        return view('allplayer', compact('players', 'majorsForCurrentHouse'));
    }

    public function destroy($id)
    {
        $player = Participant::find($id);
        if ($player) {
            $teamIds = ParticipantTeam::where('participant_id', $id)
                ->pluck('team_id');
            $player->teams()->detach();           
            if ($player->ktm_photo) {
                Storage::disk('public')->delete($player->ktm_photo);
            }
            $player->delete();
            Team::whereIn('id', $teamIds)
                ->update(['status' => 'Menunggu']);
            return redirect()->back()->with('success', 'Data pemain berhasil dihapus');
        }
        return redirect()->back()->with('error', 'Pemain tidak ditemukan');
    }
}