@extends('layouts.sidebar')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36 relative">
    <div class="w-full max-w-6xl mx-auto">

        {{-- HEADER --}}
        <header class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            
            <h2 class="text-xl sm:text-2xl font-bold text-white font-heading uppercase tracking-widest">
                All Players
            </h2>

                {{-- COMBO BOX FILTER CABLOM --}}
                <div class="relative w-full sm:w-64">                    
                    <select id="competitionFilter" 
                        class="w-full bg-[#1A1A1A] text-white border border-white/20 rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 appearance-none transition shadow-lg cursor-pointer">
                        <option value="all" selected>All</option>
                    </select>

                    <script>
                    const data = [
                        "Basket Putra", "Basket Putri", "Futsal Putra", "Voli Putra",
                        "Badminton Ganda Putra", "Badminton Tunggal Putra",
                        "Badminton Ganda Campuran", "E-sport", "Poster",
                        "Lukis", "Dance", "Fotografi"
                    ];

                    const select = document.getElementById("competitionFilter");

                    // cara paling efisien
                    select.insertAdjacentHTML(
                        "beforeend",
                        data.map(item => `<option value="${item}" style="color:white;">${item}</option>`).join("")
                    );
                    </script>
                    <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-white/50">
                        <i data-feather="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
        </header>

        {{-- TABLE CONTAINER --}}
        <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="w-full text-base text-white" style="min-width: max-content;">
                    <thead class="bg-white/5 uppercase tracking-widest text-sm">
                        <tr>
                            <th class="px-6 py-4 text-center font-bold">NO</th>
                            <th class="px-6 py-4 text-left font-bold">NAME</th>
                            <th class="px-6 py-4 text-center font-bold">NRP</th>
                            <th class="px-6 py-4 text-center font-bold">MAJOR</th>
                            <th class="px-6 py-4 text-center font-bold">DETAILS</th>
                            <th class="px-6 py-4 text-center font-bold">EDIT</th>
                            <th class="px-6 py-4 text-center font-bold">ACTION</th> 
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10 text-base" id="playerTableBody">
                        
                        @forelse ($players as $index => $player)
                            @php
                                $allCompetitions = $player->teams->pluck('competition')->implode(',');
                            @endphp

                            <tr class="player-row hover:bg-white/5 transition" data-cabloms="{{ $allCompetitions }}" style="white-space: nowrap;">
                                
                                <td class="px-6 py-4 text-center text-white">
                                    {{ $index+1 }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $player->name }}
                                </td>

                                <td class="px-6 py-4 text-center text-white">
                                    {{ $player->nrp }}
                                </td>

                                <td class="px-6 py-4 text-center text-white">
                                    {{ $player->major }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        {{-- Tombol Detail --}}
                                        <button onclick="openPlayerModal('{{ $player->id }}')"
                                           class="inline-flex px-4 py-2 text-xs font-semibold rounded-lg
                                              bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10">
                                            <i data-feather="info" class="w-5 h-5"></i>                                            
                                        </button>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        {{-- Tombol Edit --}}
                                        <button onclick="openEditPlayerModalById({{ $player->id }})"
                                           class="openEditPlayer inline-flex px-4 py-2 text-xs font-semibold rounded-lg
                                                bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                                data-id="{{ $player->id }}"
                                                data-name="{{ $player->name }}"
                                                data-nrp="{{ $player->nrp }}"
                                                data-major="{{ $player->major }}"
                                                data-dob="{{ $player->birthdate }}"
                                                data-whatsapp="{{ $player->whatsapp }}">
                                            <i data-feather="edit" class="w-5 h-5"></i>                                            
                                        </button>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Delete --}}
                                        <form action="{{ route('participant.destroy', $player->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus player dari SEMUA tim?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="shrink-0 px-4 py-2 rounded-lg bg-red-500/20 hover:bg-red-500/40 text-red-200 hover:text-white transition text-sm border border-red-500/20 flex items-center justify-center">
                                                <i data-feather="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-white/50 italic">
                                    Belum ada data pemain kontingen.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @foreach ($players as $player)
        <div id="modal-{{ $player->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-[#0a0a0a] border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col relative overflow-hidden">
                <div class="p-6 border-b border-white/10 flex justify-between items-center bg-black/50 shrink-0">
                    <h2 class="text-xl font-heading font-bold text-white uppercase tracking-widest">Player Details</h2>
                    <button onclick="closePlayerModal('{{ $player->id }}')" class="text-white/50 hover:text-white transition">
                        <i data-feather="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-5 text-sm">                   
                    <div class="space-y-6">
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl space-y-4">                                
                            <!-- Player Name -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    Player Name
                                </label>
                                <input type="text" value="{{ $player->name }}"  
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none" 
                                    readonly>
                            </div>

                            <!-- NRP -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    NRP
                                </label>
                                <input type="text" value="{{ $player->nrp }}" 
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none" 
                                    readonly>
                            </div>

                            <!-- Major -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    Major
                                </label>
                                <input type="text" value="{{ $player->major }}" 
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none" 
                                    readonly>
                            </div>

                            <!-- DOB -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    Date of Birth
                                </label>
                                <input type="text" value="{{ $player->birthdate }}" 
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none" 
                                    readonly>
                            </div>

                            <!-- KTM -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">                                
                                    KTM:  
                                    <a href="{{ asset('storage/app/public/' . $player->ktm_photo) }}" target="_blank" 
                                        class="text-blue-400 underline"> View KTM </a>                                                                            
                                </label>          
                            </div>

                            <!-- WhatsApp -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    Whatsapp Number
                                </label>
                                <input type="text" value="{{ $player->whatsapp }}" 
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none"
                                    readonly>
                            </div>    
                        </div>
                        <h3 class="text-lg font-heading font-bold text-white uppercase tracking-widest mb-4">Competitions Joined</h3>
                        {{-- Looping Tiap Lomba yang Diikuti Pemain --}}
                        @forelse($player->teams as $team)
                            <div class="bg-white/5 border border-white/10 p-4 rounded-xl space-y-4">
                                
                                {{-- 1. Nama Tim (Baru ditambahkan) --}}
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Team Name</label>
                                    <input type="text" value="{{ $team->name }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none">
                                </div>

                                {{-- 2. Cabang Lomba --}}
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Competition</label>
                                    <input type="text" value="{{ $team->competition }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white font-bold outline-none">
                                </div>
                                
                                {{-- 3. Logika Cerdas untuk Back Number & ID ML --}}
                                @if(in_array($team->competition, ['Futsal', 'Basket Putra', 'Basket Putri', 'Voli Putra', 'Voli Putri']))
                                    <div>
                                        <label class="block text-white/70 mb-1 font-semibold">Back Number</label>
                                        <input type="text" value="{{ $team->pivot->back_number ?? '-' }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none">
                                    </div>
                                @elseif($team->competition === 'E-sport')
                                    <div>
                                        <label class="block text-white/70 mb-1 font-semibold">ID Mobile Legend</label>
                                        <input type="text" value="{{ $player->mobilelegend ?? '-' }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none">
                                    </div>
                                @endif

                                {{-- 4. Status --}}
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Status</label>
                                    <input type="text" value="{{ $team->pivot->status ?? 'Menunggu' }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none">
                                </div>

                                {{-- 5. Revision --}}
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Revision</label>
                                    <textarea readonly rows="2" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none resize-none">{{ $team->pivot->revision ?? '-' }}</textarea>
                                </div>

                            </div>
                        @empty
                            <p class="text-white/50 italic text-center">Belum masuk tim apapun.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    @endforeach
</section>


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

{{-- SCRIPT IKON & FILTER & MODAL --}}
<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();

        const filterSelect = document.getElementById('competitionFilter');
        const playerRows = document.querySelectorAll('.player-row');

        if(filterSelect) {
            filterSelect.addEventListener('change', function() {
                const selectedValue = this.value;
                let counter = 1; 
                playerRows.forEach(row => {
                    const rowCabloms = row.getAttribute('data-cabloms'); 
                    if (selectedValue === 'all' || rowCabloms.includes(selectedValue)) {
                        row.style.display = ''; 
                        row.querySelector('td:first-child').innerText = counter;
                        counter++; 
                    } else {
                        row.style.display = 'none'; 
                    }
                });
            });
        }
    });

    // Fungsi Buka Tutup Modal
    function openPlayerModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
        document.getElementById('modal-' + id).classList.add('flex');
    }
    function openEditPlayerModalById(playerId) {
        const btn = document.querySelector(`.openEditPlayer[data-id='${playerId}']`);
        if (!btn) return;

        const editForm = document.getElementById('editPlayerForm');

        // Set form action
        editForm.action = `/participant/${playerId}`;

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
    const closeBtn = document.getElementById('closeEditPlayerModal');
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            document.getElementById('playerEditModal').style.display = 'none';
        });
    }
    function closePlayerModal(id) {
        document.getElementById('modal-' + id).classList.remove('flex');
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>

<style>
    /* Custom Scrollbar Khusus untuk Modal */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
</style>
{{-- Modal Edit Player --}}
@if ($errors->playerEdit->any())
<script>
    openEditPlayerModalById("{{ session('editPlayerId') }}");
</script>
@endif
@endsection
