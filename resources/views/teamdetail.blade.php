@extends('layouts.app')

@section('content')
<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- TEAM DETAIL --}}
        <section class="mb-24">
            <header class="mb-6">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Team Detail
                </h2>
                <a href="{{ url()->previous() }}"
                   class="inline-block mt-2 text-lg text-white/75 hover:text-white transition">
                    ← Back
                </a>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-center font-semibold">ID</th>
                                <th class="px-6 py-4 text-left font-semibold">Team Name</th>
                                <th class="px-6 py-4 text-center font-semibold">House</th>
                                <th class="px-6 py-4 text-center font-semibold">Competition</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-center text-white/70">
                                    {{ $team->id }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $team->name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team->house->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team->competition }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team->status }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        {{-- DIVIDER --}}
        <div class="my-24 border-t border-white/10"></div>

        {{-- PLAYER LIST --}}
        <section class="mb-24">
            <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Player List
                </h2>

                <button id="openAddPlayer"
                    class="inline-flex items-center gap-2 px-5 py-2 text-white
                            bg-blue-600 hover:bg-blue-500 rounded-lg transition
                            shadow-lg shadow-blue-600/20 border border-blue-400/20">
                    
                    {{-- Teks menggunakan font Georgia agar sesuai tema --}}
                    <span class="font-bold font-['Georgia'] text-sm sm:text-base">Add Player</span>
                    
                    {{-- Icon Plus Square --}}
                    <i data-feather="plus-square" class="w-5 h-5"></i>
                </button>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Player Name</th>
                                <th class="px-6 py-4 text-center font-semibold">Details</th>
                                <th class="px-6 py-4 text-center font-semibold">Edit</th>
                                <th class="px-6 py-4 text-center font-semibold">Delete</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @forelse ($players as $player)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4">
                                    {{ $player->name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <!-- Detail Button -->
                                    <a 
                                        href="{{ route('teamdetail', ['id' => $team->id])}}" 
                                        class="openPlayerDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                              bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10">                                        
                                        <i data-feather="info"></i>
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a 
                                        href="{{ route('teamdetail', ['id' => $team->id])}}" 
                                        class="openPlayerDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                              bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10">                                        
                                        <i data-feather="edit"></i>
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                   <form action="{{ route('teams.destroyPlayer', [$team->id, $player->id]) }}"
                                        method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus player ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                                bg-red-500/20 text-red-300 border border-red-500/20 hover:bg-red-500/30">                                        
                                            <i data-feather="trash-2"></i>
                                            
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-white/50">
                                    Belum ada data pemain
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        
        {{-- DIVIDER --}}
        <div class="my-24 border-t border-white/10"></div>

        {{-- CREW LIST --}}
        <section>
            <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Crew List
                </h2>

                <button id="openAddCrew"
                    class="inline-flex items-center gap-2 px-5 py-2 text-white
                            bg-blue-600 hover:bg-blue-500 rounded-lg transition
                            shadow-lg shadow-blue-600/20 border border-blue-400/20">
                    
                    {{-- Teks menggunakan font Georgia agar sesuai tema --}}
                    <span class="font-bold font-['Georgia'] text-sm sm:text-base">Add Crew</span>
                    
                    {{-- Icon Plus Square --}}
                    <i data-feather="plus-square" class="w-5 h-5"></i>
                </button>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Crew Name</th>
                                <th class="px-6 py-4 text-center font-semibold">Role</th>
                                <th class="px-6 py-4 text-center font-semibold">Details</th>
                                <th class="px-6 py-4 text-center font-semibold">Edit</th>
                                <th class="px-6 py-4 text-center font-semibold">Delete</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">

                            @forelse ($crews as $crew)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4">
                                    {{ $crew->crew->name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $crew->crew->role }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="#"
                                    class="openCrewDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-cyan-500/20 text-cyan-300 border border-cyan-500/20
                                            hover:bg-cyan-500/30 transition">
                                        Details
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="#"
                                    class="openCrewEdit inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-yellow-500/20 text-yellow-300 border border-yellow-500/20
                                            hover:bg-yellow-500/30 transition">
                                        Edit
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <form action="#" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                                bg-red-500/20 text-red-300 border border-red-500/20
                                                hover:bg-red-500/30 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-white/50">
                                    Belum ada data crew
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


    </div>
</section>

{{-- POP UP ADD EXISTING PLAYER --}}
<div id="addExistingPlayerModal" class="modal-overlay">

    <div class="modal-card">

        <h2 class="modal-title">Add Player</h2>

        <form action="{{ route('teams.attachPlayer', $team->id) }}" method="POST">
            @csrf

            <!-- Dropdown Participant -->
            <div style="margin-bottom:20px;">
                <label style="font-size:16px;opacity:1;">
                    Select Participant
                </label><br>

                <select name="participant_id" class="form-input h40 text-black" required>
                    @foreach($houseParticipants as $participant)
                        <option style="color:black;" value="{{ $participant->id }}">
                            {{ $participant->name }} ({{ $participant->nrp }})
                        </option>
                    @endforeach
                </select>

                
            </div>

            <!-- BUTTONS -->
            <div style="
                display:flex;
                flex-direction:column;
                gap:12px;
            ">

                <!-- Baris Atas: Cancel & Add Player -->
                <div style="
                    display:flex;
                    justify-content:space-between;
                    gap:12px;
                ">
                    <button type="button" 
                            id="closeAddExistingPlayerModal"
                            class="btn btn-cancel">
                        Cancel
                    </button>

                    <button type="submit" 
                            class="btn btn-primary">
                        Add Player
                    </button>
                </div>

                <!-- Baris Bawah: Add New Player -->
                <button type="button" 
                        id="openAddNewPlayerModal"
                        class="btn btn-secondary"
                        style="width:100%;">
                    + Add New Player
                </button>

            </div>

        </form>
    </div>
</div>

<div id="addNewPlayerModal" class="modal-overlay">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Add Player</h2>

        <!-- FORM -->
        <form action="{{ route('teams.addPlayer', $team->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Player Name -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Player Name
                </label><br>

                <input type="text" name="name" class="form-input h35" required>
            </div>

            <!-- NRP -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    NRP
                </label><br>

                <input type="text" name="nrp" class="form-input h35" required>
            </div>

            <!-- Major -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Major
                </label><br>

                <select name="major" class="form-input h40 text-black" required>
                    @foreach($majorsForCurrentHouse as $major)
                        <option style="color:black;" value="{{ $major }}">
                            {{ $major }} 
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- KTM -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Upload KTM
                </label><br>

               <input type="file" name="ktm_photo" class="form-input h45" required>
            </div>

            <!-- WhatsApp Number -->
            <div style="margin-bottom:16px;">
                <label style="font-size:16px;opacity:1;">
                    Whatsapp Number
                </label><br>

                <input type="text" name="whatsapp" class="form-input h35" required>
            </div>

            <!-- Mobile Legend -->
            @if ($team->competition === 'E-sport')
                <div style="margin-bottom:16px;">
                    <label style="font-size:16px;opacity:1;">
                        Mobile Legend
                    </label><br>
                    <input type="text" name="mobilelegend" class="form-input h35">
                </div>
            @endif

            <!-- BUTTONS -->
            <div style="
                display:flex;
                justify-content:flex-end;
                gap:8px;
            ">

                <button type="button" id="closeAddNewPlayerModal" class="btn btn-cancel">
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    Add Participant
                </button>
                
            </div>
        </form>
    </div>
</div>


<div id="addCrewModal" class="modal-overlay">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Add Crew</h2>

        <!-- FORM -->
        <form>

            <!-- Crew Name -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    Crew Name
                </label><br>

                <input class="form-input h35">
            </div>

            <!-- WhatsApp Number -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    Whatsapp Number
                </label><br>

                <input class="form-input h35">
            </div>

            <!-- Role -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    Role
                </label><br>

                <select class="form-input h40">
                    <option style="color:black;">Official</option>
                    <option style="color:black;">Coach</option>
                    <option style="color:black;">Assistant Coach</option>
                    <option style="color:black;">Role</option>
                </select>
            </div>

            <!-- NRP -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    NRP
                    <span style="opacity:0.5;">(optional)</span>
                </label>

                <input class="form-input h35">
            </div>

            <!-- Major -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;">
                    Major 
                    <span style="opacity:0.5;">(optional)</span>
                </label>

                <select name="major" class="form-input h40 text-black" >
                    @foreach($majorsForCurrentHouse as $major)
                        <option style="color:black;" value="{{ $major }}">
                            {{ $major }} 
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- KTM -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Upload KTM
                    <span style="opacity:0.5;">(optional)</span>
                </label>

               <input type="file" class="form-input h45">
            </div>
           

            <!-- BUTTONS -->
            <div style="
                display:flex;
                justify-content:flex-end;
                gap:8px;
            ">

                <button type="button" id="closeAddCrewModal" class="btn btn-cancel">
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    Add Crew
                </button>
                
            </div>
        </form>
    </div>
</div>

{{-- POP UP DETAIL PLAYER --}}
<div id="playerDetailModal" class="modal-overlay">
    <div class="modal-card">

        <h2 class="modal-title">Detail Player</h2><br>

        <!-- Name -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">Name: </label>
            <label style="font-size:16px;">
                {{ $player->participant->name ?? '-' }}
            </label>
        </div>

        <!-- NRP -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">NRP: </label>
            <label style="font-size:16px;">
                {{ $player->participant->nrp ?? '-' }} 
            </label>
        </div>

        <!-- MAJOR -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">Major: </label>
            <label style="font-size:16px;">
                {{ $player->participant->major ?? '-' }}
            </label>
        </div>

        <!-- KTM -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">KTM: </label><br>
            <label style="font-size:16px;">
                {{ $player->participant->ktm_photo ?? '-' }}
            </label>
        </div>

        <!-- WHATSAPP -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">WhatsApp Number: </label>
            <label style="font-size:16px;">
                {{ $player->participant->whatsapp ?? '-' }}
            </label>
        </div>

        <!-- STATUS -->
        <div style="margin-bottom:16px;">
            <label style="font-size:16px;">Status: </label>
            <label style="font-size:16px;">
                {{ $player->participant->status ?? '-' }}
            </label>
        </div>

        <!-- BUTTONS -->
        <div style="
            display:flex;
            justify-content:flex-end;
            gap:8px;
        ">

            <div class="modal-actions">
                <button type="button" id="closePlayerModal" class="btn btn-cancel">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- POP UP DETAIL CREW --}}
<div id="crewDetailModal" class="modal-overlay">
    <div class="modal-card">

        <h2 class="modal-title">Detail Crew</h2><br>

        <!-- Name -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">Name: </label>
            <label style="font-size:16px;">Juan Melolo</label>
        </div>

        <!-- WHATSAPP -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">WhatsApp Number: </label>
            <label style="font-size:16px;">+6285888889999 </label>
        </div>

        <!-- ROLE -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">Role: </label>
            <label style="font-size:16px;">Coach </label>
        </div>

        <!-- NRP -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">NRP: </label>
            <label style="font-size:16px;">160424999 </label>
        </div>

        <!-- MAJOR -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">Major: </label>
            <label style="font-size:16px;">Teknik Informatika </label>
        </div>

        <!-- KTM -->
        <div style="margin-bottom:10px;">
            <label style="font-size:16px;">KTM: </label><br>
            <label style="font-size:16px;">juanGanteng.jpg </label>
        </div>

        <!-- STATUS -->
        <div style="margin-bottom:16px;">
            <label style="font-size:16px;">Status: </label>
            <label style="font-size:16px;">Hidup </label>
        </div>

        <!-- BUTTONS -->
        <div style="
            display:flex;
            justify-content:flex-end;
            gap:8px;
        ">

            <div class="modal-actions">
                <button type="button" id="closeCrewModal" class="btn btn-cancel">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

{{-- POP UP EDIT PLAYER --}}
<div id="playerEditModal" class="modal-overlay">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Edit Player</h2>

        <!-- FORM -->
        <form>

            <!-- Player Name -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Player Name
                </label><br>

                <input class="form-input h35" type="text" value="Juan Melolo">
            </div>

            <!-- NRP -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    NRP
                </label><br>

                <input class="form-input h35" type="text" value="160424999">
            </div>

            <!-- Major -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Major
                </label><br>

                <select class="form-input h40">
                    <option style="color:black;">Teknik Informatika</option>
                    <option style="color:black;">Teknik Industri</option>
                    <option style="color:black;">Teknik Elektro</option>
                </select>
            </div>

            <!-- KTM -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Upload KTM
                </label><br>

               <input type="file" class="form-input h45">
            </div>

            <!-- WhatsApp Number -->
            <div style="margin-bottom:16px;">
                <label style="font-size:16px;opacity:1;">
                    Whatsapp Number
                </label><br>

                <input class="form-input h35" type="text" value="+6285888889999">
            </div>

            <!-- BUTTONS -->
            <div style="
                display:flex;
                justify-content:flex-end;
                gap:8px;
            ">

                <button type="button" id="cancelPlayerEditModal" class="btn btn-cancel">
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    Edit
                </button>
                
            </div>
        </form>
    </div>
</div>

{{-- POP UP EDIT CREW --}}
<div id="crewEditModal" class="modal-overlay">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Edit Crew</h2>

        <!-- FORM -->
        <form>

            <!-- Crew Name -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    Crew Name
                </label><br>

                <input class="form-input h35" type="text" value="Juan Melolo">
            </div>

            <!-- WhatsApp Number -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    Whatsapp Number
                </label><br>

                <input class="form-input h35" type="text" value="+6285888889999">
            </div>

            <!-- Role -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    Role
                </label><br>

                <select class="form-input h40">
                    <option style="color:black;">Official</option>
                    <option style="color:black;">Coach</option>
                    <option style="color:black;">Assistant Coach</option>
                    <option style="color:black;">Role</option>
                </select>
            </div>

            <!-- NRP -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;opacity:1;">
                    NRP
                    <span style="opacity:0.5;">(optional)</span>
                </label>

                <input class="form-input h35" type="text" value="160424999">
            </div>

            <!-- Major -->
            <div style="margin-bottom:5px;">
                <label style="font-size:16px;">
                    Major 
                    <span style="opacity:0.5;">(optional)</span>
                </label>

                <select class="form-input h40">

                    <!-- NULL OPTION -->
                    <option style="color:black;" value="">Tidak ada</option>
                    <option style="color:black;" value="Teknik Informatika">Teknik Informatika</option>
                    <option style="color:black;" value="Teknik Industri">Teknik Industri</option>
                    <option style="color:black;" value="Teknik Elektro">Teknik Elektro</option>
                
                </select>
            </div>

            <!-- KTM -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Upload KTM
                    <span style="opacity:0.5;">(optional)</span>
                </label>

               <input class="form-input h35" type="file" class="form-input h45">
            </div>
           

            <!-- BUTTONS -->
            <div style="
                display:flex;
                justify-content:flex-end;
                gap:8px;
            ">

                <button type="button" id="cancelCrewEditModal" class="btn btn-cancel">
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    Edit
                </button>
                
            </div>
        </form>
    </div>
</div>

<script>
    //Add Player
    // ===== EXISTING PLAYER MODAL =====
    const openExistingBtn = document.getElementById('openAddPlayer');
    const existingModal = document.getElementById('addExistingPlayerModal');
    const closeExistingBtn = document.getElementById('closeAddExistingPlayerModal');

    if(openExistingBtn){
        openExistingBtn.onclick = () => existingModal.style.display = "flex";
    }

    if(closeExistingBtn){
        closeExistingBtn.onclick = () => existingModal.style.display = "none";
    }


    // ===== NEW PLAYER MODAL =====
    const openNewBtn = document.getElementById('openAddNewPlayerModal');
    const newModal = document.getElementById('addNewPlayerModal');
    const closeNewBtn = document.getElementById('closeAddNewPlayerModal');

    if(openNewBtn){
        openNewBtn.onclick = () => {
            existingModal.style.display = "none";
            newModal.style.display = "flex";
        };
    }

    if(closeNewBtn){
        closeNewBtn.onclick = () => newModal.style.display = "none";
    }


    // ===== CLOSE MODAL WHEN CLICK OUTSIDE =====
    window.onclick = function(event) {
        if (event.target === existingModal) {
            existingModal.style.display = "none";
        }
        if (event.target === newModal) {
            newModal.style.display = "none";
        }
    };
    

    //Add Crew
    const addCrewBtn = document.getElementById('openAddCrew');
    const addCrewModal = document.getElementById('addCrewModal');
    const cancelAddCrewBtn = document.getElementById('closeAddCrewModal');
    addCrewBtn.onclick = () => addCrewModal.style.display = "flex";
    cancelAddCrewBtn.onclick = () => addCrewModal.style.display = "none";

    //Detail Player
    const playerDetailBtns = document.querySelectorAll('.openPlayerDetail');
    const playerDetailModal = document.getElementById('playerDetailModal');
    const closePlayerDetailBtn = document.getElementById('closePlayerModal');
    playerDetailBtns.forEach(btn => {
        btn.onclick = (e) => {
            e.preventDefault();
            playerDetailModal.style.display = "flex";
        }
    });
    closePlayerDetailBtn.onclick = () => {playerDetailModal.style.display = "none";}

    //Detail Crew
    const crewDetailBtns = document.querySelectorAll('.openCrewDetail');
    const crewDetailModal = document.getElementById('crewDetailModal');
    const closeCrewDetailBtn = document.getElementById('closeCrewModal');
    crewDetailBtns.forEach(btn => {
        btn.onclick = (e) => {
            e.preventDefault();
            crewDetailModal.style.display = "flex";
        }
    });
    closeCrewDetailBtn.onclick = () => {crewDetailModal.style.display = "none";}

    //Edit Player
    const playerEditBtns = document.querySelectorAll('.openPlayerEdit');
    const playerEditModal = document.getElementById('playerEditModal');
    const cancelPlayerEditBtn = document.getElementById('cancelPlayerEditModal');
    playerEditBtns.forEach(btn => {
        btn.onclick = (e) => {
            e.preventDefault();
            playerEditModal.style.display = "flex";
        }
    });
    cancelPlayerEditBtn.onclick = () => {playerEditModal.style.display = "none";}

    //Edit Crew
    const crewEditBtns = document.querySelectorAll('.openCrewEdit');
    const crewEditModal = document.getElementById('crewEditModal');
    const cancelCrewEditBtn = document.getElementById('cancelCrewEditModal');
    crewEditBtns.forEach(btn => {
        btn.onclick = (e) => {
            e.preventDefault();
            crewEditModal.style.display = "flex";
        }
    });
    cancelCrewEditBtn.onclick = () => {crewEditModal.style.display = "none";}
</script>
<script src="https:unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>
@endsection