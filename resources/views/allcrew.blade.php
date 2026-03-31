@extends('layouts.sidebar')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36 relative">
    <div class="w-full max-w-6xl mx-auto">

        {{-- HEADER --}}
        <header class="mb-6 flex flex-col md:flex-row md:items-end justify-between gap-4">
            
            <div class="flex flex-col gap-1">
                <h2 class="text-xl sm:text-2xl font-bold text-white font-heading uppercase tracking-widest">
                    All Crews
                </h2>
            </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    
                    {{-- FILTER ROLE --}}
                    <div class="relative w-full sm:w-48">
                        <select id="roleFilter" 
                            class="w-full bg-[#1A1A1A] text-white border border-white/20 rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 appearance-none transition shadow-lg cursor-pointer">
                            <option value="all" selected>All</option>
                            <option style="color:white;" value="Coach">Coach</option>
                            <option style="color:white;" value="Assistant Coach">Assistant Coach</option>
                            <option style="color:white;" value="Medic">Medic</option>
                            <option style="color:white;" value="Koorcab">Koorcab</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-white/50">
                            <i data-feather="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    {{-- FILTER CABLOM --}}
                    <div class="relative w-full sm:w-60">
                        <select id="competitionFilter" 
                            class="w-full bg-[#1A1A1A] text-white border border-white/20 rounded-lg px-4 py-2 text-sm sm:text-base focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 appearance-none transition shadow-lg cursor-pointer">
                            <option value="all" selected>All</option>
                            <option style="color:white;" value="Basket Putra">Basket Putra</option>
                            <option style="color:white;" value="Basket Putri">Basket Putri</option>
                            <option style="color:white;" value="Futsal">Futsal</option>
                            <option style="color:white;" value="Voli Putra">Voli Putra</option>
                            <option style="color:white;" value="Voli Putri">Voli Putri</option>
                            <option style="color:white;" value="Badminton Ganda Putra">Badminton Ganda Putra</option>
                            <option style="color:white;" value="Badminton Ganda Putri">Badminton Ganda Putri</option>
                            <option style="color:white;" value="Badminton Ganda Campuran">Badminton Ganda Campuran</option>
                            <option style="color:white;" value="E-sport">E-sport</option>
                            <option style="color:white;" value="Poster">Poster</option>
                            <option style="color:white;" value="Lukis">Lukis</option>
                            <option style="color:white;" value="Dance">Dance</option>
                            <option style="color:white;" value="Fotografi">Fotografi</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-white/50">
                            <i data-feather="chevron-down" class="w-4 h-4"></i>
                        </div>
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
                            <th class="px-6 py-4 text-center font-bold">No</th>
                            <th class="px-6 py-4 text-left font-bold">Name</th>
                            <th class="px-6 py-4 text-center font-bold">NRP</th>
                            <th class="px-6 py-4 text-center font-bold">Major</th>
                            <th class="px-6 py-4 text-center font-bold">Details</th>
                            <th class="px-6 py-4 text-center font-bold">Edit</th>
                            <th class="px-6 py-4 text-center font-bold">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10 text-base">
                        
                        @forelse ($crews as $index => $crew)
                            @php
                                $allCompetitions = $crew->teams->pluck('competition')->implode(',');
                                $allRoles = $crew->teams->map(fn($t) => $t->pivot->role)->unique()->implode(',');
                            @endphp
                            <tr class="crew-row hover:bg-white/5 transition" data-cabloms="{{ $allCompetitions }}" data-roles="{{ $allRoles }}" style="white-space: nowrap;">
                                
                                <td class="px-6 py-4 text-center text-white">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $crew->name }}
                                </td>

                                <td class="px-6 py-4 text-center text-white">
                                    {{ !empty($crew->nrp) ? $crew->nrp : '-' }}
                                </td>

                                <td class="px-6 py-4 text-center text-white     ">
                                    {{ !empty($crew->major) ? $crew->major : '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <button onclick="openCrewModal('{{ $crew->id }}')"
                                           class="inline-flex px-4 py-2 text-xs font-semibold rounded-lg
                                              bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10">
                                            <i data-feather="info" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        <button onclick="openEditCrewModal('{{ $crew->id }}')"
                                           class="openCrewEdit inline-flex px-4 py-2 text-xs font-semibold rounded-lg
                                              bg-white/10 hover:bg-white/20 transition text-sm text-white border border-white/10"
                                              data-id="{{ $crew->id }}"
                                              data-name="{{ $crew->name }}"
                                              data-whatsapp="{{ $crew->whatsapp }}"
                                              data-nrp="{{ $crew->nrp }}"
                                              data-major="{{ $crew->major }}">
                                            <i data-feather="edit" class="w-5 h-5"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('crew.destroy', $crew->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus crew ini sepenuhnya?')">
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
                                <td colspan="6" class="text-center py-6 text-white/50 italic">
                                    Belum ada data crew kontingen.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- MODAL KHUSUS UNTUK TIAP CREW --}}
    @foreach ($crews as $crew)
        <div id="modal-{{ $crew->id }}" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
            <div class="bg-[#0a0a0a] border border-white/10 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col relative overflow-hidden">
                
                <div class="p-6 border-b border-white/10 flex justify-between items-center bg-black/50 shrink-0">
                    <h2 class="text-xl font-heading font-bold text-white uppercase tracking-widest">Crew Details</h2>
                    <button onclick="closeCrewModal('{{ $crew->id }}')" class="text-white/50 hover:text-white transition">
                        <i data-feather="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-5 text-sm">

                    <div class="space-y-6">
                        <div class="bg-white/5 border border-white/10 p-4 rounded-xl space-y-4">                                
                            <!-- Crew Name -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    Crew Name
                                </label>
                                <input type="text" value="{{ $crew->name }}"  
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none" 
                                    readonly>
                            </div>
                            <!-- WhatsApp -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    Whatsapp Number
                                </label>
                                <input type="text" value="{{ $crew->whatsapp }}" 
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none"
                                    readonly>
                            </div>                            
                            <!-- NRP -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    NRP
                                </label>
                                <input type="text" value="{{ $crew->nrp ?? '-'}}" 
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none" 
                                    readonly>                                
                            </div>
                            <!-- Major -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">
                                    Major
                                </label>
                                <input type="text" value="{{ $crew->major ?? '-'}}" 
                                    class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none" 
                                    readonly>
                            </div>
                            <!-- KTM -->
                            <div>
                                <label class="block text-white/70 mb-1 font-semibold">                                
                                    KTM: 
                                    @if($crew->ktm_photo)
                                        <a href="{{ asset('storage/' . $crew->ktm_photo) }}" 
                                        target="_blank" 
                                        class="text-blue-400 underline">
                                            View KTM
                                        </a>
                                    @else
                                        <span class="text-gray-400">
                                            Tidak ada KTM
                                        </span>
                                    @endif
                                </label>          
                            </div>                              
                        </div>
                        <h3 class="text-lg font-heading font-bold text-white uppercase tracking-widest mb-4">Competitions Joined</h3>
                        @forelse($crew->teams as $team)
                            <div class="bg-white/5 border border-white/10 p-4 rounded-xl space-y-4">
                                
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Team Name</label>
                                    <input type="text" value="{{ $team->name }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white font-bold outline-none">
                                </div>

                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Competition</label>
                                    <input type="text" value="{{ $team->competition }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white font-bold outline-none">
                                </div>
                                
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Role</label>
                                    <input type="text" value="{{ $team->pivot->role }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none">
                                </div>

                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Status</label>
                                    <input type="text" value="{{ $team->pivot->status ?? 'Menunggu' }}" readonly class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none ">
                                </div>

                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Revision</label>
                                    <textarea readonly rows="2" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none resize-none">{{ $team->pivot->revision ?? '-' }}</textarea>
                                </div>

                            </div>
                        @empty
                            <p class="text-white/50 italic text-center">Belum ditugaskan ke tim apapun.</p>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    @endforeach

</section>

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
                
                <div style="margin-bottom:10px;">
                    <label style="font-size:16px;opacity:1;">
                        NRP <span style="opacity:0.5;">(optional)</span>
                    </label><br>
                    <input name="nrp" id="editCrewNRP" class="form-input h35" type="text">
                    @error('nrp', 'crewEdit')
                        <div style="color:red; margin-top:6px;">
                            {{ $message }}
                        </div>
                    @enderror
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

{{-- SCRIPT IKON, MODAL & MULTI-FILTER --}}
<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        feather.replace();

        const compFilter = document.getElementById('competitionFilter');
        const roleFilter = document.getElementById('roleFilter');
        const crewRows = document.querySelectorAll('.crew-row');

        function applyFilters() {
            const selectedComp = compFilter ? compFilter.value : 'all';
            const selectedRole = roleFilter ? roleFilter.value : 'all';

            crewRows.forEach(row => {
                const rowCabloms = row.getAttribute('data-cabloms') || ''; 
                const rowRoles = row.getAttribute('data-roles') || ''; 

                const matchComp = (selectedComp === 'all' || rowCabloms === selectedComp);
                const matchRole = (selectedRole === 'all' || rowRoles === selectedRole);

                if (matchComp && matchRole) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none'; 
                }
            });
        }

        if(compFilter) compFilter.addEventListener('change', applyFilters);
        if(roleFilter) roleFilter.addEventListener('change', applyFilters);
    });

    function openCrewModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
        document.getElementById('modal-' + id).classList.add('flex');
    }
    function openEditCrewModal(crewId) {
        // Ambil tombol berdasarkan data-id
        const btn = document.querySelector(`.openCrewEdit[data-id='${crewId}']`);
        if (!btn) return;

        // Ambil data dari attribute
        const name = btn.getAttribute('data-name');
        const whatsapp = btn.getAttribute('data-whatsapp');
        const nrp = btn.getAttribute('data-nrp');
        const major = btn.getAttribute('data-major');

        // Isi form
        document.getElementById('editCrewName').value = name ?? '';
        document.getElementById('editCrewWhatsapp').value = whatsapp ?? '';
        document.getElementById('editCrewNRP').value = nrp ?? '';
        document.getElementById('editCrewMajor').value = major ?? '';

        // Set action form (PENTING)
        const form = document.getElementById('editCrewForm');
        form.action = `/crew/${crewId}`;

        // Tampilkan modal
        document.getElementById('crewEditModal').style.display = 'flex';
    }
        document.getElementById('cancelCrewEditModal').addEventListener('click', function () {
        document.getElementById('crewEditModal').style.display = 'none';
    });
    function closeCrewModal(id) {
        document.getElementById('modal-' + id).classList.remove('flex');
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }
</style>
{{-- Modal Edit Player Crew --}}
@if ($errors->crewEdit->any())
<script>
    openEditCrewModal("{{ session('editCrewId') }}");
</script>
@endif
@endsection