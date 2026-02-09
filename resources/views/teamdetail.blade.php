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
                            @php
                                $team = [
                                    'id' => 1,
                                    'name' => 'Hahahhaha',
                                    'house' => 'House of Arcana',
                                    'competition' => 'Basket',
                                    'status' => 'Menunggu'
                                ];
                            @endphp

                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4 text-center text-white/70">
                                    {{ $team['id'] }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $team['name'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team['house'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team['competition'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $team['status'] }}
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
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white
                           bg-blue-600 hover:bg-blue-500 rounded-lg transition
                           shadow-lg shadow-blue-600/20 border border-blue-400/20">
                    +
                    Add Player
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
                            @php
                                $players = [
                                    ['id' => 1, 'name' => 'John Snow'],
                                    ['id' => 2, 'name' => 'Arya Stark'],
                                    ['id' => 3, 'name' => 'Tyrion Lannister'],
                                ];
                            @endphp

                            @foreach ($players as $player)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4">
                                    {{ $player['name'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="#"
                                       class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                              bg-cyan-500/20 text-cyan-300 border border-cyan-500/20
                                              hover:bg-cyan-500/30 transition">
                                        Details
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="#"
                                       class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
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
                            @endforeach
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
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white
                        bg-blue-600 hover:bg-blue-500 rounded-lg transition
                        shadow-lg shadow-blue-600/20 border border-blue-400/20">
                    +
                    Add Crew
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
                            @php
                                $crews = [
                                    ['id' => 1, 'name' => 'Brandon Stark', 'role' => 'Coach'],
                                    ['id' => 2, 'name' => 'Eddard Stark', 'role' => 'Coach'],
                                ];
                            @endphp

                            @foreach ($crews as $crew)
                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-4">
                                    {{ $crew['name'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $crew['role'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="#"
                                    class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
                                            bg-cyan-500/20 text-cyan-300 border border-cyan-500/20
                                            hover:bg-cyan-500/30 transition">
                                        Details
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <a href="#"
                                    class="inline-flex px-3 py-1 text-xs font-semibold rounded-lg
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


    </div>
</section>


<div id="addPlayerModal" class="modal-overlay">

    <div class="modal-card small">

        <!-- TITLE -->
        <h2 class="modal-title small">Add Player</h2>

        <!-- FORM -->
        <form>

            <!-- Player Name -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    Player Name
                </label><br>

                <input class="form-input h35">
            </div>

            <!-- NRP -->
            <div style="margin-bottom:10px;">
                <label style="font-size:16px;opacity:1;">
                    NRP
                </label><br>

                <input class="form-input h35">
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

                <input class="form-input h35">
            </div>

            <!-- BUTTONS -->
            <div style="
                display:flex;
                justify-content:flex-end;
                gap:8px;
            ">

                <button type="button" id="closeAddPlayerModal" class="btn btn-cancel">
                    Cancel
                </button>

                <button type="submit" class="btn btn-primary">
                    Add Team
                </button>
                
            </div>
        </form>
    </div>
</div>


<div id="addCrewModal" class="modal-overlay">

    <div class="modal-card">

        <!-- TITLE -->
        <h2 class="modal-title small">Add Crew</h2>

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


<script>
    const addPlayerBtn = document.getElementById('openAddPlayer');
    const addPlayerModal = document.getElementById('addPlayerModal');
    const cancelAddPlayerBtn = document.getElementById('closeAddPlayerModal');

    addPlayerBtn.onclick = () => addPlayerModal.style.display = "flex";
    cancelAddPlayerBtn.onclick = () => addPlayerModal.style.display = "none";

    const addCrewBtn = document.getElementById('openAddCrew');
    const addCrewModal = document.getElementById('addCrewModal');
    const cancelAddCrewBtn = document.getElementById('closeAddCrewModal');

    addCrewBtn.onclick = () => addCrewModal.style.display = "flex";
    cancelAddCrewBtn.onclick = () => addCrewModal.style.display = "none";
</script>

@endsection