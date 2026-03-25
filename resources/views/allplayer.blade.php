@extends('layouts.sidebar')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36 relative">
    <div class="w-full max-w-6xl mx-auto">
        <header class="mb-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            
            <h2 class="text-xl sm:text-2xl font-bold text-white font-heading uppercase tracking-widest">
                All Players
            </h2>

                {{-- COMBO BOX FILTER CABLOM --}}
                <div class="relative w-full sm:w-64">
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
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10 text-base" id="playerTableBody">
                        
                        @forelse ($players as $index => $player)
                            @php
                                $allCompetitions = $player->teams->pluck('competition')->implode(',');
                            @endphp

                            <tr class="player-row hover:bg-white/5 transition" data-cabloms="{{ $allCompetitions }}" style="white-space: nowrap;">
                                
                                <td class="px-6 py-4 text-center text-white">
                                    {{ $index + 1 }}
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
                                           class="shrink-0 px-4 py-1.5 rounded-lg bg-blue-600/20 hover:bg-blue-600/40 transition text-sm font-bold text-blue-400 hover:text-white border border-blue-500/20 flex items-center gap-2">
                                            <i data-feather="info" class="w-4 h-4"></i>
                                            Detail
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-white/50 italic">
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
                    <h3 class="text-lg font-heading font-bold text-white uppercase tracking-widest mb-4">Competitions Joined</h3>
                    <div class="space-y-6">
                        @forelse($player->teams as $team)
                            <div class="bg-white/5 border border-white/10 p-4 rounded-xl space-y-4">
                                
                                {{-- 1. Cabang Lomba --}}
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Competition</label>
                                    <input type="text" value="{{ $team->competition }}" disabled class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white font-bold outline-none cursor-not-allowed">
                                </div>
                                
                                {{-- 2. Logika Cerdas untuk Back Number & ID ML --}}
                                @if(in_array($team->competition, ['Futsal', 'Basket Putra', 'Basket Putri', 'Voli Putra', 'Voli Putri']))
                                    <div>
                                        <label class="block text-white/70 mb-1 font-semibold">Back Number</label>
                                        <input type="text" value="{{ $team->pivot->back_number ?? '-' }}" disabled class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none cursor-not-allowed">
                                    </div>
                                @elseif($team->competition === 'E-sport')
                                    <div>
                                        <label class="block text-white/70 mb-1 font-semibold">ID Mobile Legend</label>
                                        <input type="text" value="{{ $player->mobilelegend ?? '-' }}" disabled class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none cursor-not-allowed">
                                    </div>
                                @endif

                                {{-- 3. Status --}}
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Status</label>
                                    <input type="text" value="{{ $team->pivot->status ?? 'Menunggu' }}" disabled class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none cursor-not-allowed">
                                </div>

                                {{-- 4. Revision --}}
                                <div>
                                    <label class="block text-white/70 mb-1 font-semibold">Revision</label>
                                    <textarea disabled rows="2" class="w-full bg-black/40 border border-white/10 rounded-lg px-4 py-2 text-white outline-none cursor-not-allowed resize-none">{{ $team->pivot->revision ?? '-' }}</textarea>
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

                playerRows.forEach(row => {
                    const rowCabloms = row.getAttribute('data-cabloms'); 
                    
                    if (selectedValue === 'all' || rowCabloms.includes(selectedValue)) {
                        row.style.display = ''; 
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
@endsection