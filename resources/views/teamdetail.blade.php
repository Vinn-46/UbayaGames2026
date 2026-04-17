@extends('layouts.sidebar')

@section('content')
<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- TEAM DETAIL --}}
        <section class="mb-24">
            <header class="mb-6 flex justify-between items-start">
            <!-- Kiri -->
            <div>
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Team Detail
                </h2> 

                <a href="{{ route('teamlist')}}" 
                class="inline-block mt-2 text-lg text-white/75 hover:text-white transition">
                    ← Back
                </a> 
            </div>
            </header>

            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-6 py-4 text-center font-semibold">Team Name</th>
                                <th class="px-6 py-4 text-center font-semibold">House</th>
                                <th class="px-6 py-4 text-center font-semibold">Competition</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-center">
                                    {{ $team->name ?? '-' }}
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
            @if ($team->revision!==null)
                <h2 class="text-xl sm:text-l font-heading font-bold text-white uppercase tracking-widest"
                    style="margin-top:20px;">
                    Revision Note
                </h2> 
                <textarea 
                    class="bg-black/60 hover:bg-white/5 border-none text-white p-2 rounded-lg transition resize-none"  
                    style="height:120px; margin-top:20px; width: 100%; padding: 15px; border-radius: 8px;" 
                    readonly>{{ $team->revision }}</textarea>
            @endif
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
                                <th class="px-6 py-4 text-center font-semibold">No</th>
                                <th class="px-6 py-4 text-left font-semibold">Player Name</th>
                                <th class="px-6 py-4 text-center font-semibold">Role</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                                <th class="px-6 py-4 text-center font-semibold">Details</th>
                                <th class="px-6 py-4 text-center font-semibold">Edit</th>
                                <th class="px-6 py-4 text-center font-semibold">Delete</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">
                            @forelse ($players as $index => $player)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-center">
                                    {{ $index+1 }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $player->name }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $player->pivot->role }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $player->pivot->status }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <!-- Detail Button -->                                    
                                    <button type="button" 
                                        class="openPlayerDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                              bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                              data-name="{{ $player->name }}"
                                              data-role="{{ $player->pivot->role }}"
                                              data-nrp="{{ $player->nrp }}"
                                              data-major="{{ $player->major }}"
                                              data-dob="{{ $player->birthdate }}"
                                              data-ktm="{{ $player->ktm_photo }}"
                                              data-whatsapp="{{ $player->whatsapp }}"
                                              data-status="{{ $player->pivot->status ?? '-' }}"
                                              data-mobilelegend="{{ $player->mobilelegend }}"
                                              data-revision="{{ $player->pivot->revision }}"   
                                              data-backnumber="{{ $player->pivot->back_number ?? '-' }}">                   
                                        <i data-feather="info"></i>
                                    </button>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <button type="button"
                                        class="editPlayerButton inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                        onclick="openEditPlayerModalById({{ $player->id }})"
                                        data-id="{{ $player->id }}"
                                        data-name="{{ $player->name }}"
                                        data-role="{{ $player->pivot->role }}"
                                        data-nrp="{{ $player->nrp }}"
                                        data-major="{{ $player->major }}"
                                        data-dob="{{ $player->birthdate }}"
                                        data-whatsapp="{{ $player->whatsapp }}"
                                        data-mobilelegend="{{ $player->mobilelegend }}"
                                        data-backnumber="{{ $player->pivot->back_number ?? '-' }}">   
                                    <i data-feather="edit"></i>
                                    </button>
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
                                <td colspan="7" class="text-center py-6 text-white/50">
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
                                <th class="px-6 py-4 text-center font-semibold">No</th>
                                <th class="px-6 py-4 text-left font-semibold">Crew Name</th>
                                <th class="px-6 py-4 text-center font-semibold">Role</th>
                                <th class="px-6 py-4 text-center font-semibold">Status</th>
                                <th class="px-6 py-4 text-center font-semibold">Details</th>
                                <th class="px-6 py-4 text-center font-semibold">Edit</th>
                                <th class="px-6 py-4 text-center font-semibold">Delete</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-white/10">

                            @forelse ($crews as $index => $crew)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-center">
                                    {{ $index+1 }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $crew->name }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $crew->pivot->role }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $crew->pivot->status }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                
                                <button type="button" 
                                        class="openCrewDetail inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                            data-id="{{ $crew->id }}"
                                            data-name="{{ $crew->name }}"
                                            data-whatsapp="{{ $crew->whatsapp }}"
                                            data-role="{{ $crew->pivot->role }}"
                                            data-dob="{{ $crew->birthdate }}"
                                            data-nrp="{{ $crew->nrp ?? '-'}} "
                                            data-major="{{ $crew-> major }}"
                                            data-ktm="{{ $crew->ktm_photo }}"
                                            data-status="{{ $crew->pivot->status }}"
                                            data-revision="{{ $crew->pivot->revision }}">    
                                        <i data-feather="info"></i>
                                </button>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <button type="button"
                                        class="openCrewEdit inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                        onclick="openEditCrewModalById({{ $crew->id }})"
                                        data-id="{{ $crew->id }}"
                                        data-name="{{ $crew->name }}"
                                        data-whatsapp="{{ $crew->whatsapp }}"
                                        data-dob="{{ $crew->birthdate }}"
                                        data-role="{{ $crew->pivot->role }}"
                                        data-nrp="{{ $crew->nrp }}"
                                        data-major="{{ $crew->major  }}">
                                        <i data-feather="edit"></i>
                                    </button>
                                </td>                                
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('crew.destroyCrew', [$team->id, $crew->id]) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus crew ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                                bg-red-500/20 text-red-300 border border-red-500/20 hover:bg-red-500/30 transition">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-white/50">
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
        
        <form action="{{ route('participant.attachPlayer', $team->id) }}" method="POST">
            @csrf

            <!-- Dropdown Participant -->
            <div style="margin-bottom:16px;">
                <label style="font-size:16px;opacity:1;">
                    Select Player
                </label><br>

                <select name="participant_id" class="form-input h40 text-black" required>
                    <option value="" disabled selected>-- Select Participant --</option>
                    @forelse($houseParticipants as $participant)
                        <option style="color:black;" value="{{ $participant->id }}">
                            {{ $participant->name }} ({{ $participant->nrp }})
                        </option>
                    @empty
                        <option value="" disabled selected>Belum ada pemain</option>
                    @endforelse
                </select>
                @foreach (['participant','esport', 'crewExist'] as $field)
                    @error($field, 'addExistingPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                @endforeach 
            </div>

            <!-- Back Number -->
            @if (in_array($team->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                <div style="margin-bottom:16px;">
                    <label style ="font-size:16px;opacity:1;">
                        Back Number                    
                    </label><br>
                    <input 
                    type="number" 
                    class="form-input h35
                            disabled:bg-gray-400 disabled:hover:bg-gray-400 
                            disabled:cursor-not-allowed disabled:opacity-70"    
                            name="backnumber" min="1" max="100" step="1" required
                            {{ $houseParticipants->isEmpty() ? 'disabled' : '' }}>
                    @error('backnumber', 'addExistingPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror 
                </div>
            @endif
            <!-- Mobile Legend -->
            @if ($team->competition === 'E-sport')
                <div style="margin-bottom:16px;">
                    <label style="font-size:16px;opacity:1;">
                        ID Mobile Legend                    
                    </label><br>

                    <input type="text" 
                    class="form-input h35
                            disabled:bg-gray-400 disabled:hover:bg-gray-400 
                            disabled:cursor-not-allowed disabled:opacity-70"    
                            name="mobilelegend" class="form-input h35" required
                            {{ $houseParticipants->isEmpty() ? 'disabled' : '' }}>
                </div> 
                @error('idMlExist', 'addExistingPlayer')
                    <div style="color:red; margin-top:6px;">
                        {{ $message }}
                    </div>
                @enderror 
            @endif  
            <!-- Role -->
            <div style="margin-bottom:16px;">
                <label style="font-size:16px;opacity:1;">
                    Role
                </label><br>
                <select name="role"
                    class="form-input h40 text-black form-input h35
                        disabled:bg-gray-400 disabled:hover:bg-gray-400 
                        disabled:cursor-not-allowed disabled:opacity-70" required
                        {{ $houseParticipants->isEmpty() ? 'disabled' : '' }}>
                    <option value="" disabled selected>-- Select Role --</option>
                    <option style="color:black;" value="Utama">Utama</option>
                    @if (in_array($team->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 'E-sport']))
                        <option style="color:black;" value="Cadangan">Cadangan</option>
                    @endif
                </select>
                @foreach (['exceedUtama','noCadangan','exceedCadangan'] as $field)
                    @error($field, 'addExistingPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                @endforeach
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
                            class="btn btn-cancel hover:bg-gray-500">
                        Cancel
                    </button>

                    <button type="submit"
                        class="btn btn-primary bg-blue-600 hover:bg-blue-500 
                            disabled:bg-gray-400 disabled:hover:bg-gray-400 
                            disabled:cursor-not-allowed disabled:opacity-70"
                        {{ $houseParticipants->isEmpty() ? 'disabled' : '' }}>
                        Add Player
                    </button>
                </div>

                <!-- Baris Bawah: Add New Player -->
                <button type="button" 
                        id="openAddNewPlayerModal"
                        class="btn btn-secondary hover:bg-blue-500"
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
        <div class="modal-body">
            <!-- FORM -->
            <form action="{{ route('participant.addPlayer', $team->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Player Name -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Player Name
                    </label><br>
                    <input type="text" name="name" class="form-input h35" required>
                    @error('crewExist', 'addNewPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- NRP -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        NRP
                    </label><br>

                    <input type="text" name="nrp" class="form-input h35" required>
                    @error('nrp', 'addNewPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Major -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Major
                    </label><br>

                    <select name="major" class="form-input h40 text-black" required>
                        <option value="" disabled selected>-- Select Major --</option>
                        @foreach($majorsForCurrentHouse as $major)
                            <option style="color:black;" value="{{ $major }}">
                                {{ $major }} 
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DOB -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Date of Birth
                    </label><br>
                    <input 
                        type="date" 
                        name="birthdate" 
                        required
                        max="<?= date('Y-m-d') ?>"
                        class="form-input h40"
                        style="-webkit-appearance: auto; appearance: auto; color-scheme: dark;">               
                </div>

                <!-- KTM -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Upload KTM
                    </label><br>
                <input type="file" name="ktm_photo" class="form-input h45" required>
                @error('ktm', 'addNewPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- WhatsApp Number -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Whatsapp Number
                    </label><br>
                    <input type="text" name="whatsapp" class="form-input h35" required>
                </div>

                <!-- Back Number -->
                @if (in_array($team->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                    <div style="margin-bottom:10px;">
                        <label style ="font-size:16px;opacity:1;">
                            Back Number                    
                        </label><br>
                        <input type="number" name="backnumber" min="1" max="100" step="1"  class="form-input h35" required>
                        @error('backnumber', 'addNewPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif
                
                <!-- Mobile Legend -->
                @if ($team->competition === 'E-sport')
                    <div style="margin-bottom:10px;">
                        <label style="font-size:16px;opacity:1;">
                            ID Mobile Legend                    
                        </label><br>
                        <input type="text" name="mobilelegend" class="form-input h35" required>
                    </div> 
                    @error('idMlExist', 'addNewPlayer')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror 
                @endif   

                <!-- Role -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Role
                    </label><br>
                        <select name="role" class="form-input h40 text-black" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        <option style="color:black;" value="Utama">Utama</option>
                        @if (in_array($team->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 'E-sport']))
                            <option style="color:black;" value="Cadangan">Cadangan</option>
                        @endif
                    </select>
                    @foreach (['exceedUtama','noCadangan','exceedCadangan'] as $field)
                        @error($field, 'addNewPlayer')
                            <div style="color:red; margin-top:6px;">
                                {{ $message }}
                            </div>
                        @enderror
                    @endforeach
                </div>
                
                <!-- BUTTONS -->
                <div style="
                    display:flex;
                    justify-content:space-between;
                    gap:8px;
                ">

                    <button type="button" id="closeAddNewPlayerModal" class="btn btn-cancel hover:bg-gray-500">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Add Player
                    </button>
                    
                </div>
            </form>
        </div>        
    </div>
</div>

<div id="addExistingCrewModal" class="modal-overlay">

    <div class="modal-card">

        <h2 class="modal-title">Add Crew</h2>

        <form action="{{ route('crew.attachCrew', $team->id) }}" method="POST">
            @csrf

            <!-- Dropdown Crew -->
            <div style="margin-bottom:20px;">
                <label style="font-size:16px;opacity:1;">
                    Select Crew
                </label><br>

                <select name="crew_id" class="form-input h40 text-black" required>
                    <option value="" disabled selected>-- Select Crew --</option>
                    @forelse($houseCrews as $crew)
                        <option style="color:black;" value="{{ $crew->id }}">
                            {{ $crew->name }} 
                        </option>
                    @empty
                        <option value="" disabled selected>Belum ada crew</option>
                    @endforelse
                </select>
                @foreach (['crew','playerExist'] as $field)
                    @error($field, 'addExistingCrew')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                @endforeach
            </div>

            <!-- Role Selector -->
            <div style="margin-bottom:20px;">
                <label style="font-size:16px;opacity:1;">
                    Role
                </label><br>
                
                <select name="role" class="form-input h40 text-black
                    disabled:bg-gray-400 disabled:hover:bg-gray-400 
                    disabled:cursor-not-allowed disabled:opacity-70" required
                    {{ $houseCrews->isEmpty() ? 'disabled' : '' }}>                
                    
                    <option value="" disabled selected>-- Select Role --</option>
                    <option style="color:black;" value="Koorcab">Koorcab</option>
                    <option style="color:black;" value="Coach">Coach</option>
                    <option style="color:black;" value="Assistant Coach">Assistant Coach</option>
                    <option style="color:black;" value="Medic">Medic</option>
                </select>

                @error('role', 'addExistingCrew')
                <div style="color:red; margin-top:6px;">
                    {{ $message }}
                </div>
                @enderror
            </div>


            <!-- BUTTONS -->
            <div style="
                display:flex;
                flex-direction:column;
                gap:12px;
            ">

                <!-- Row: Cancel + Add -->
                <div style="
                    display:flex;
                    justify-content:space-between;
                    gap:12px;
                ">
                    <button type="button"
                            id="closeAddExistingCrewModal"
                            class="btn btn-cancel hover:bg-gray-500">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary bg-blue-600 hover:bg-blue-500
                            disabled:bg-gray-400 disabled:hover:bg-gray-400 
                            disabled:cursor-not-allowed disabled:opacity-70"
                        {{ $houseCrews->isEmpty() ? 'disabled' : '' }}>
                        Add Crew
                    </button>
                </div>

                <!-- Row: Add New Crew -->
                <button type="button"
                        id="openAddCrewModal"
                        class="btn btn-secondary hover:bg-blue-500"
                        style="width:100%;">
                    + Add New Crew
                </button>
            </div>
        </form>
    </div>
</div>


<div id="addNewCrewModal" class="modal-overlay">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Add Crew</h2>

        <!-- FORM -->
        <div class="modal-body">
            <form action="{{ route('crew.addCrew', $team) }}" method="POST" enctype="multipart/form-data">
            @csrf
                <!-- Crew Name -->
                <div style="margin-bottom:5px;">
                    <label style="font-size:16px;opacity:1;">
                        Crew Name
                    </label><br>
                    <input name="name" class="form-input h35" required>
                    @foreach (['crew','playerExist'] as $field)
                        @error($field, 'addNewCrew')
                            <div style="color:red; margin-top:6px;">
                                {{ $message }}
                            </div>
                        @enderror
                    @endforeach
                </div>

                <!-- WhatsApp Number -->
                <div style="margin-bottom:5px;">
                    <label style="font-size:16px;opacity:1;">
                        Whatsapp Number
                    </label><br>
                    <input name="whatsapp" class="form-input h35" required>                    
                </div>
                <!-- DOB -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Date of Birth
                    </label><br>
                    <input 
                        type="date" 
                        name="birthdate" 
                        required
                        max="<?= date('Y-m-d') ?>"
                        class="form-input h40"
                        style="-webkit-appearance: auto; appearance: auto; color-scheme: dark;">               
                </div>
                <!-- Role -->
                <div style="margin-bottom:5px;">
                    <label style="font-size:16px;opacity:1;">Role</label><br>
                    <select name="role" class="form-input h40 text-black" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        <option style="color:black;" value="Koorcab">Koorcab</option>
                        <option style="color:black;" value="Coach">Coach</option>
                        <option style="color:black;" value="Assistant Coach">Assistant Coach</option>
                        <option style="color:black;" value="Medic">Medic</option>
                    </select>
                    @error('role', 'addNewCrew')
                    <div style="color:red; margin-top:6px;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <!-- NRP -->
                <div style="margin-bottom:5px;">
                    <label style="font-size:16px;opacity:1;">
                        NRP
                        <span style="opacity:0.5;">(optional)</span>
                    </label>
                    <input name="nrp" class="form-input h35">
                    @error('nrp', 'addNewCrew')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Major -->
                <div style="margin-bottom:5px;">
                    <label style="font-size:16px;">
                        Major 
                        <span style="opacity:0.5;">(optional)</span>
                    </label>

                    <select name="major" class="form-input h40 text-black" >
                        <option value="" disabled selected>-- Select Major --</option>
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
                <input type="file" name="ktm_photo"class="form-input h45">
                @error('ktm', 'addNewCrew')
                    <div style="color:red; margin-top:6px;">
                        {{ $message }}
                    </div>
                @enderror
                </div>
            

                <!-- BUTTONS -->
                <div style="
                    display:flex;
                    justify-content:space-between;
                    gap:8px;
                ">

                    <button type="button" id="closeAddCrewModal" class="btn btn-cancel hover:bg-gray-500">
                        Cancel
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Add Crew
                    </button>
                    
                </div>
            </form>
        </div>        
    </div>
</div>

{{-- POP UP DETAIL PLAYER --}}
<div id="playerDetailModal" class="modal-overlay" style="display:none;">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Detail Player</h2>

        <div class="modal-body">
            <!-- FORM (readonly) -->
            <form>

                <!-- Player Name -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Player Name
                    </label><br>

                    <input type="text" id="modalName" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- NRP -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        NRP
                    </label><br>

                    <input type="text" id="modalNRP" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- Major -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Major
                    </label><br>

                    <input type="text" id="modalMajor" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- DOB -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Date of Birth
                    </label><br>

                    <input type="text" id="modalDOB" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- KTM -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        KTM:  
                        <a href="#" target="_blank" id="modalKTM"
                            class="text-blue-400 underline">
                            View KTM
                        </a>
                    </label><br>               
                </div>

                <!-- WhatsApp -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Whatsapp Number
                    </label><br>

                    <input type="text" id="modalWhatsapp" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- Status -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Status
                    </label><br>

                    <input type="text" id="modalStatus" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- Role -->                    
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Role
                    </label><br>
                    <input type="text" id="modalRole" 
                        class="form-input h35" 
                        readonly>
                </div>

                <!-- Back Number -->
                @if (in_array($team->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                    <div style="margin-bottom:10px;">
                        <label style="font-size:16px;opacity:1;">
                            Back Number
                        </label><br>

                        <input type="text" id="modalBackNumber" 
                            class="form-input h35" 
                            readonly>
                    </div>
                @endif
                
                <!-- Mobile Legend -->
                @if ($team->competition === 'E-sport')
                    <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        ID Mobile Legend
                        @if ($team->competition !== 'E-sport')
                            <span style="opacity:0.5;">(optional)</span>
                        @endif
                    </label><br>
                    <input type="text" id="modalMobilelegend" 
                            class="form-input h35"
                            readonly>
                </div>    
                @endif    
                
                <!-- Revision -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Revision                    
                    </label><br>
                    <textarea name="revision" id="modalRevision" 
                            class="form-input" style="height:80px;"
                            readonly>
                    </textarea>
                </div>  
                <!-- BUTTON -->
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" 
                            id="closePlayerModal" 
                            class="btn btn-cancel hover:bg-gray-500">
                        Close
                    </button>
                </div>
            </form>
        </div>        
    </div>
</div>

{{-- POP UP DETAIL CREW --}}
<div id="crewDetailModal" class="modal-overlay" style="display:none;">
    <div class="modal-card">
        <h2 class="modal-title">Detail Crew</h2>
        <div class="modal-body">
            <form>
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Crew Name</label><br>
                    <input type="text" id="modalCrewName" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Whatsapp Number</label><br>
                    <input type="text" id="modalCrewWhatsapp" class="form-input h35" readonly>
                </div>

                <!-- DOB -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Date of Birth</label><br>
                    <input type="text" id="modalCrewDOB" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Role</label><br>
                    <input type="text" id="modalCrewRole" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">NRP</label><br>
                    <input type="text" id="modalCrewNRP" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Major</label><br>
                    <input type="text" id="modalCrewMajor" class="form-input h35" readonly>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        KTM:
                        <a href="#" target="_blank" id="modalCrewKTM" class="text-blue-400 underline">
                            View KTM
                        </a>
                    </label>
                </div>

                <div style="margin-bottom:16px;">
                    <label style="font-size:16px;opacity:1;">Status</label><br>
                    <input type="text" id="modalCrewStatus" class="form-input h35" readonly>
                </div>
                <!-- Revision -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Revision                    
                    </label><br>
                    <textarea name="revision" id="modalCrewRevision" 
                            class="form-input" style="height:80px;"
                            readonly>
                    </textarea>
                </div>  
                <div style="display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" id="closeCrewModal" class="btn btn-cancel hover:bg-gray-500">
                        Close
                    </button>
                </div>
            </form>
        </div>        
    </div>
</div>

{{-- POP UP EDIT PLAYER --}}
<div id="playerEditModal" class="modal-overlay" style="display:none;">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title">Edit Player</h2>        
        <div class="modal-body">
            <!-- FORM -->
            <form id="editPlayerForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')                
                <!-- Player Name -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Player Name
                    </label><br>

                    <input type="text" name="name" id="editName"
                        class="form-input h35">
                </div>

                <!-- NRP -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        NRP
                    </label><br>
                    <input type="text" name="nrp" id="editNRP" class="form-input h35">
                    @error('nrp', 'playerEdit')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Major -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Major
                    </label><br>

                    <select name="major" id="editMajor" 
                            class="form-input h40 text-black" required>
                        <option value="" disabled selected>-- Select Major --</option>
                        @foreach($majorsForCurrentHouse as $major)
                            <option style="color:black;" value="{{ $major }}">
                                {{ $major }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- DOB -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Date of Birth
                    </label><br>
                    <input 
                        type="date" 
                        name="birthdate" 
                        id = "editDOB"
                        required
                        max="<?= date('Y-m-d') ?>"
                        class="form-input h40"
                        style="-webkit-appearance: auto; appearance: auto; color-scheme: dark;">               
                </div>

                <!-- KTM Upload -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Upload KTM 
                        <span style="opacity:0.5;">(optional)</span>
                    </label><br>

                    <input type="file" name="ktm_photo" class="form-input h60">
                    @error('ktm', 'playerEdit')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- WhatsApp -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Whatsapp Number
                    </label><br>

                    <input type="text" name="whatsapp" id="editWhatsapp"
                        class="form-input h35">
                </div>
                <!-- Back Number -->
                @if (in_array($team->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                    <div style="margin-bottom:10px;">
                        <label style="font-size:16px;opacity:1;">
                            Back Number
                        </label><br>
                        <input type="number" name="backnumber" min="1" max="100" step="1"  id="editBackNumber" class="form-input h35">
                        @error('backnumber', 'playerEdit')
                            <div style="color:red; margin-top:6px;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif
                
                <!-- Mobile Legend -->
                @if ($team->competition === 'E-sport')
                    <div style="margin-bottom:10px;">
                        <label style="font-size:16px;opacity:1;">
                            ID Mobile Legend
                        </label><br>
                        <input type="text" name="mobilelegend" id="editMobilelegend" class="form-input h35">
                        @error('idMlExist', 'playerEdit')
                            <div style="color:red; margin-top:6px;">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>    
                @endif        

                <!-- Role -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Role
                    </label><br>
                    <select name="role" id="editPlayerRole" class="form-input h40 text-black" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        <option style="color:black;" value="Utama">Utama</option>
                        @if (in_array($team->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 'E-sport']))
                            <option style="color:black;" value="Cadangan">Cadangan</option>
                        @endif                        
                    </select>
                    @foreach (['exceedUtama','noCadangan','exceedCadangan'] as $field)
                        @error($field, 'playerEdit')
                            <div style="color:red; margin-top:6px;">
                                {{ $message }}
                            </div>
                        @enderror
                    @endforeach
                </div>
                
                <!-- BUTTON -->
                <div style="display:flex; justify-content:space-between; gap:8px;">
                    <button type="button"
                            id="closeEditPlayerModal"
                            class="btn btn-cancel hover:bg-gray-500">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary hover:bg-blue-600">
                        Update Player
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- POP UP EDIT CREW --}}
<div id="crewEditModal" class="modal-overlay" style="display:none;">
    <div class="modal-card">
        <h2 class="modal-title">Edit Crew</h2>
        <div class="modal-body">
            <form id="editCrewForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Crew Name</label><br>
                    <input name="name" id="editCrewName" class="form-input h35" type="text" required>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Whatsapp Number</label><br>
                    <input name="whatsapp" id="editCrewWhatsapp" class="form-input h35" type="text" required>
                </div>

                <!-- DOB -->
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Date of Birth</label><br>
                    <input 
                        type="date" 
                        name="birthdate" 
                        id = "editCrewDOB"
                        required
                        max="<?= date('Y-m-d') ?>"
                        class="form-input h40"
                        style="-webkit-appearance: auto; appearance: auto; color-scheme: dark;">               
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">Role</label><br>
                    <select name="role" id="editCrewRole" class="form-input h40 text-black" required>
                        <option value="" disabled selected>-- Select Role --</option>
                        <option style="color:black;" value="Coach">Coach</option>
                        <option style="color:black;" value="Assistant Coach">Assistant Coach</option>
                        <option style="color:black;" value="Medic">Medic</option>
                        <option style="color:black;" value="Koorcab">Koorcab</option>
                    </select>
                    @error('role', 'crewEdit')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        NRP <span style="opacity:0.5;">(optional)</span>
                    </label><br>
                    <input name="nrp" id="editCrewNRP" class="form-input h35" type="text">
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;">
                        Major <span style="opacity:0.5;">(optional)</span>
                    </label><br>
                    <select name="major" id="editCrewMajor" class="form-input h40 text-black">
                        <option value="" disabled selected>-- Select Major --</option>
                        @foreach($majorsForCurrentHouse as $major)
                            <option style="color:black;" value="{{ $major }}">{{ $major }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        Upload KTM <span style="opacity:0.5;">(optional)</span>
                    </label><br>
                    <input type="file" name="ktm_photo" class="form-input h45">
                    @error('ktm', 'crewEdit')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div style="display:flex; justify-content:space-between; gap:8px;">
                    <button type="button" id="cancelCrewEditModal" class="btn btn-cancel hover:bg-gray-500">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Update Crew
                    </button>
                </div>
            </form>
        </div>        
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
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
    

   // ===== EXISTING CREW MODAL =====
    const openCrewBtn = document.getElementById('openAddCrew');
    const existingCrewModal = document.getElementById('addExistingCrewModal');
    const closeExistingCrewBtn = document.getElementById('closeAddExistingCrewModal');

    if(openCrewBtn){
        openCrewBtn.onclick = () => existingCrewModal.style.display = "flex";
    }

    if(closeExistingCrewBtn){
        closeExistingCrewBtn.onclick = () => existingCrewModal.style.display = "none";
    }


    // ===== NEW CREW MODAL =====
    const openNewCrewBtn = document.getElementById('openAddCrewModal');
    const newCrewModal = document.getElementById('addNewCrewModal');
    const closeNewCrewBtn = document.getElementById('closeAddCrewModal');

    if(openNewCrewBtn){
        openNewCrewBtn.onclick = () => {
            existingCrewModal.style.display = "none";
            newCrewModal.style.display = "flex";
        };
    }

    if(closeNewCrewBtn){
        closeNewCrewBtn.onclick = () => newCrewModal.style.display = "none";
    }

    //Detail Player
    const detailButtons = document.querySelectorAll('.openPlayerDetail');
    const modal = document.getElementById('playerDetailModal');
    const closeBtn = document.getElementById('closePlayerModal');
       
    detailButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            document.getElementById('modalName').value = btn.dataset.name || '-';
            document.getElementById('modalNRP').value = btn.dataset.nrp || '-';
            document.getElementById('modalMajor').value = btn.dataset.major || '-';
            document.getElementById('modalDOB').value = btn.dataset.dob || '-';
            document.getElementById('modalWhatsapp').value = btn.dataset.whatsapp || '-';
            document.getElementById('modalStatus').value = btn.dataset.status || '-';            
            document.getElementById('modalRevision').value = btn.dataset.revision || '-';
            const mobileLegendInput = document.getElementById('modalMobilelegend');
            if (mobileLegendInput) {
                mobileLegendInput.value = btn.dataset.mobilelegend || '-';
            }
            const backNumberInput = document.getElementById('modalBackNumber');
            if (backNumberInput) {
                backNumberInput.value = btn.dataset.backnumber || '-';
            }
            const roleInput = document.getElementById('modalRole');
            if (roleInput) {
                roleInput.value = btn.dataset.role || '';
            }
            // KTM PATH (storage)
            let ktmPath = btn.dataset.ktm;

            if (ktmPath) {
                let fullPath = `/storage/app/public/${ktmPath}`;

                document.getElementById('modalKTM').href = fullPath;                
            }

            modal.style.display = 'flex';
        });
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }    

    // ===== DETAIL CREW MODAL =====
    const crewDetailBtns = document.querySelectorAll('.openCrewDetail');
    const crewDetailModal = document.getElementById('crewDetailModal');
    const closeCrewDetailBtn = document.getElementById('closeCrewModal');

    crewDetailBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            document.getElementById('modalCrewName').value     = btn.dataset.name     || '-';
            document.getElementById('modalCrewWhatsapp').value = btn.dataset.whatsapp || '-';
            document.getElementById('modalCrewRole').value     = btn.dataset.role     || '-';
            document.getElementById('modalCrewDOB').value      = btn.dataset.dob     || '-';
            document.getElementById('modalCrewNRP').value      = btn.dataset.nrp      || '-';
            document.getElementById('modalCrewMajor').value    = btn.dataset.major    || '-';
            document.getElementById('modalCrewStatus').value   = btn.dataset.status   || '-';
            document.getElementById('modalCrewRevision').value = btn.dataset.revision || '-';
            
            let ktmPath = btn.dataset.ktm;
            let modalLink = document.getElementById('modalCrewKTM');
            if (ktmPath) {
                modalLink.href = `/storage/app/public/${ktmPath}`;
                modalLink.textContent = "View KTM"; // optional, reset text if needed
                modalLink.style.pointerEvents = "auto";  // ensure link is clickable
                modalLink.style.color = ""; // reset any styling
            }
            else{
                modalLink.href = "#"; // prevent navigation
                modalLink.textContent = "Tidak ada KTM"; 
                modalLink.style.pointerEvents = "none"; 
                modalLink.style.color = "gray"; 
            }                

            crewDetailModal.style.display = 'flex';
        });
    });

    if (closeCrewDetailBtn) {
        closeCrewDetailBtn.addEventListener('click', () => {
            crewDetailModal.style.display = 'none';
        });
    }
    
    // ===== CHANGE NAME MODAL =====
    const openChangeNameBtn = document.getElementById('openChangeTeamNameModal');
    const changeTeamNameModal = document.getElementById('changeTeamNameModal');
    const closeChangeNameBtn = document.getElementById('closeChangeTeamNameModal');

    if(openChangeNameBtn){
        openChangeNameBtn.onclick = () => {
            changeTeamNameModal.style.display = "flex";
        };
    }
    if(closeChangeNameBtn){
        closeChangeNameBtn.onclick = () => changeTeamNameModal.style.display = "none";
    }
    
});    
</script>
<script>
    // ===== EDIT PLAYER MODAL =====    
    // OPEN MODAL
    function openEditPlayerModalById(playerId) {
        const btn = document.querySelector(`.editPlayerButton[data-id='${playerId}']`);
        if (!btn) return;

        const editForm = document.getElementById('editPlayerForm');

        // Set form action
        editForm.action = `/teams/{{ $team->id }}/participant/${playerId}`;

        // Isi data ke input
        document.getElementById('editName').value = btn.dataset.name || '';
        document.getElementById('editNRP').value = btn.dataset.nrp || '';
        document.getElementById('editMajor').value = btn.dataset.major || '';
        document.getElementById('editDOB').value = btn.dataset.dob || '';
        document.getElementById('editWhatsapp').value = btn.dataset.whatsapp || '';

        const editML = document.getElementById('editMobilelegend');
        if (editML) {
            editML.value = btn.dataset.mobilelegend || '';
        }

        const editBack = document.getElementById('editBackNumber');
        if (editBack) {
            editBack.value = btn.dataset.backnumber || '';
        }

        const editRole = document.getElementById('editPlayerRole');
        if (editRole) {
            editRole.value = btn.dataset.role || '';
        }

        // Tampilkan modal
        document.getElementById('playerEditModal').style.display = 'flex';
    };
        document.getElementById('closeEditPlayerModal').addEventListener('click', function () {
        document.getElementById('playerEditModal').style.display = 'none';
    });
    // ===== EDIT CREW MODAL =====
    function openEditCrewModalById(crewId) {
        // Ambil tombol berdasarkan data-id
        const btn = document.querySelector(`.openCrewEdit[data-id='${crewId}']`);
        if (!btn) return;

        // Ambil data dari attribute
        const name = btn.getAttribute('data-name');
        const whatsapp = btn.getAttribute('data-whatsapp');
        const role = btn.getAttribute('data-role');
        const dob = btn.getAttribute('data-dob')
        const nrp = btn.getAttribute('data-nrp');
        const major = btn.getAttribute('data-major');

        // Isi form
        document.getElementById('editCrewName').value = name ?? '';
        document.getElementById('editCrewWhatsapp').value = whatsapp ?? '';
        document.getElementById('editCrewRole').value = role ?? '';
        document.getElementById('editCrewDOB').value = dob ?? '';
        document.getElementById('editCrewNRP').value = nrp ?? '';
        document.getElementById('editCrewMajor').value = major ?? '';

        // Set action form (PENTING)
        const form = document.getElementById('editCrewForm');
        form.action = `/teams/{{ $team->id }}/crew/${crewId}`;

        // Tampilkan modal
        document.getElementById('crewEditModal').style.display = 'flex';
    }
        document.getElementById('cancelCrewEditModal').addEventListener('click', function () {
        document.getElementById('crewEditModal').style.display = 'none';
    });
</script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();
    });
</script>
{{-- Modal Add New Player --}}
@if ($errors->addNewPlayer->any())
<script>
    document.getElementById('addNewPlayerModal').style.display = 'flex';
</script>
@endif

{{-- Modal Add New Crew --}}
@if ($errors->addNewCrew->any())
<script>
    document.getElementById('addNewCrewModal').style.display = 'flex';
</script>
@endif

{{-- Modal Add Existing Player --}}
@if ($errors->addExistingPlayer->any())
<script>
    document.getElementById('addExistingPlayerModal').style.display = 'flex';
</script>
@endif

{{-- Modal Add Existing Crew --}}
@if ($errors->addExistingCrew->any())
<script>
    document.getElementById('addExistingCrewModal').style.display = 'flex';
</script>
@endif

{{-- Modal Edit Player --}}
@if ($errors->playerEdit->any())
<script>
    openEditPlayerModalById("{{ session('editPlayerId') }}");
</script>
@endif

{{-- Modal Edit Player Crew --}}
@if ($errors->crewEdit->any())
<script>
    openEditCrewModalById("{{ session('editCrewId') }}");
</script>
@endif

{{-- Modal Change Team Name --}}
@if ($errors->changeTeamName->any())
<script>
    document.getElementById('changeTeamNameModal').style.display = 'flex';
</script>
@endif
@endsection

@if('openExistingCrewModal')    
<script>
    document.getElementById('addExistingCrewModal').style.display = 'flex';
</script>
@endif
