@extends('layouts.app')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- ================= HEADER ================= --}}
        <section class="mb-10">
            <header class="mb-6">
                <h2 class="text-xl sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Schedule
                </h2>
            </header>
        </section>

        {{-- ================= FILTER BAR ================= --}}
        <form method="GET" action="{{ route('schedule') }}" class="mb-6 flex flex-col sm:flex-row gap-3">

            <input type="hidden" name="date" value="{{ request('date', now()->toDateString()) }}">
            
            {{-- COMBO BOX 1: Filter By --}}
            <select id="filter_by" name="filter_by"
                    class="bg-black/60 border border-white/10 text-white rounded-lg px-4 py-3 text-m focus:outline-none focus:ring-1 focus:ring-white/30">
                <option value="" disabled {{ !request('filter_by') ? 'selected' : '' }}>-- Filter By --</option>
                <option value="cabang"  {{ request('filter_by') === 'cabang'  ? 'selected' : '' }}>Cabang Lomba</option>
                <option value="house"   {{ request('filter_by') === 'house'   ? 'selected' : '' }}>House</option>
            </select>

            {{-- COMBO BOX 2 --}}
            <select id="search" name="search"
                    class="flex-1 bg-black/60 border border-white/10 text-white rounded-lg px-4 py-3 text-m focus:outline-none focus:ring-1 focus:ring-white/30
                    style="box-sizing: border-box; font-size: 0.875rem;">
            </select>

            {{-- BUTTON SEARCH --}}
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/10 text-white text-sm font-semibold transition">
                Search
            </button>

            {{-- BUTTON CLEAR --}}
            @if(request('search'))
                <a href="{{ route('schedule', ['date' => request('date')]) }}"
                   class="inline-flex items-center justify-center px-5 py-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-white/60 text-sm font-semibold transition">
                    Clear
                </a>
            @endif

        </form>


        @php
            // House logo map -> Sesuaikan nama file ini dengan yang ada di assets/fakultas/
            $houseLogos = [
                'Fortis'   => 'teknik.png',
                'Justicia' => 'hukum.png',
                'Mercator' => 'bisnis.png',
                'Praxis'   => 'poltek.png', 
                'Arcana'   => 'psiko.png',
                'Elixir'   => 'farmasi.png',
                'Vivens'   => 'teknobio.png',
                'Creatio'  => 'indus kreatif.png',
                'Vitalis'  => 'kedok.png',
            ];
        @endphp
    
        
        {{-- DATE HEADER --}}
        <div class="mb-12">
            <h3 class="text-lg font-heading font-bold text-white text-center uppercase tracking-widest mb-6 mt-6">
                <div class="flex items-center justify-between gap-3 w-full">                     
                    <div class="flex flex-col items-start flex-1 gap-3">
                        <a href="{{ route('schedule', ['date' => \Carbon\Carbon::parse(request('date', now()))->subDay()->toDateString()]) }}" 
                        class="inline-flex items-center gap-2 px-3 py-2 text-white bg-blue-600 hover:bg-blue-500 rounded-lg transition shadow-lg shadow-blue-600/20 border border-blue-400/20">
                            <i data-feather="arrow-left" class="w-5 h-5"></i> 
                        </a>
                    </div>
                    <div class="flex flex-col items-center justify-center min-w-[140px]">
                        {{ convertToDate(request('date')) }}
                    </div>
                    <div class="flex flex-col items-end flex-1 gap-3">
                        <a href="{{ route('schedule', ['date' => \Carbon\Carbon::parse(request('date', now()))->addDay()->toDateString()]) }}" 
                        class="inline-flex items-center gap-2 px-3 py-2 text-white bg-blue-600 hover:bg-blue-500 rounded-lg transition shadow-lg shadow-blue-600/20 border border-blue-400/20">
                            <i data-feather="arrow-right" class="w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            </h3>
            @forelse($groupedSchedules as $competitionName => $matches)
                <div class="mb-8 w-full">
                    <table class="w-full table-fixed text-base text-white bg-gray-900 shadow-xl rounded-2xl overflow-hidden border-separate border-spacing-0">
                        <thead class="bg-white/5 uppercase tracking-widest text-sm">
                            <tr>
                                <th class="px-6 py-4 text-lg text-center font-bold text-yellow-400"> 
                                    {{ $competitionName }} 
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10 text-base bg-black/20">
                        @foreach ($matches as $match)       
                            {{-- BODY: Daftar Pertandingan --}}                                                            
                            @php
                                $finished  = $match->is_finished;
                                $homeTeam = $match->teams->where('pivot.home_away', 'Home')->first();
                                $awayTeam = $match->teams->where('pivot.home_away', 'Away')->first();
                                $getHouseName = function($teamName) {
                                    if (!$teamName) return null;
                                    return explode(' ', trim($teamName))[0];
                                };
                                $homeHouse = $homeTeam ? $getHouseName($homeTeam->name) : null;
                                $awayHouse = $awayTeam ? $getHouseName($awayTeam->name) : null;
                                $logoHome = ($homeHouse && isset($houseLogos[$homeHouse])) 
                                            ? $houseLogos[$homeHouse] 
                                            : 'default.png';
                                            
                                $logoAway = ($awayHouse && isset($houseLogos[$awayHouse])) 
                                            ? $houseLogos[$awayHouse] 
                                            : 'default.png';
                            @endphp
                            <tr>
                                <td class="px-2 py-4 w-full border-t border-white/50 my-3 hover:bg-white/20" >
                                    {{-- WRAPPER UTAMA: Berbaris ke bawah (Kolom) --}}
                                    <div class="flex flex-col items-center gap-3 w-full">
                                        @if ($match->type === 'Pertandingan')                 
                                            {{-- BARIS ATAS: Tim Home, Score/VS, Tim Away --}}
                                            <div class="flex items-center justify-between gap-3 w-full">
                                                
                                                {{-- LOGO & NAMA HOME --}}
                                                <div class="flex flex-col items-center flex-1 gap-3">
                                                    <img src="{{ asset('assets/fakultas/' . $logoHome) }}" 
                                                        class="w-12 h-12 object-contain flex-shrink-0">
                                                    <span class="text-white text-center font-bold text-l uppercase tracking-wide">
                                                        {{ $homeTeam->name }}
                                                    </span>
                                                </div>

                                                {{-- SCORE / VS (Tengah) --}}
                                                <div class="flex flex-col items-center justify-center min-w-[140px]">
                                                    <span class="text-sm text-center uppercase tracking-widest text-white/70 mb-1">
                                                        {{ $match->phase }}
                                                    </span>

                                                    @if($finished)
                                                        <div class="flex items-center gap-3">
                                                            <span class="text-2xl text-center font-bold" style="color: #eab308;">{{ $homeTeam->pivot->total_score }}</span>
                                                            <span class="text-white/30 text-2xl">VS</span>
                                                            <span class="text-2xl text-center font-bold" style="color: #eab308;">{{ $awayTeam->pivot->total_score }}</span>
                                                        </div>
                                                        <span class="text-sm text-white text-center uppercase tracking-tighter mt-2">Finished</span>
                                                    @else                                                
                                                        <span class="text-white/30 text-2xl">VS</span>
                                                    @endif    
                                                </div>

                                                {{-- NAMA & LOGO AWAY --}}
                                                <div class="flex flex-col items-center flex-1 gap-3">                                                
                                                    <img src="{{ asset('assets/fakultas/' . $logoAway) }}" 
                                                        class="w-12 h-12 object-contain flex-shrink-0">
                                                    <span class="text-white text-center font-bold text-l uppercase tracking-wide">
                                                        {{ $awayTeam->name }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            {{-- LAYOUT PERLOMBAAN --}}
                                            <div class="flex flex-col items-center justify-center w-full px-4">
                                                <span class="text-white text-center text-xl font-bold tracking-wide">{{ $match->name }}</span>
                                            </div>
                                        @endif
                                        {{-- BARIS BAWAH: Venue & Time (Turun ke bawah) --}}
                                        @if(!$finished || $finished && $match->type === 'Perlombaan')
                                            <div class="w-full border-t border-white/10 my-3"></div>
                                            <div class="flex items-center justify-center w-full">
                                                <span class="text-[5px] text-white text-center leading-relaxed tracking-wide">
                                                    @if(!$finished)
                                                        {{ $match->venue }} ({{ \Carbon\Carbon::parse($match->time)->format('H.i') }} WIB)
                                                    @elseif ($finished && $match->type === 'Perlombaan')
                                                        FINISHED
                                                    @endif
                                                </span>
                                            </div>
                                        @endif 
                                        </div>
                                    </td>
                                </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div> 
            @empty
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-xl px-6 py-12 text-center">
                    <p class="text-white text-lg mb-4 mt-4">Tidak ada jadwal yang ditemukan.</p>
                </div>
            @endforelse                 
        </div>      
</section>    

{{-- 3. FOOTER (Pindahkan ke luar div konten) --}}
<div class="w-full mt-auto">
    @include('layouts.footer')
</div>   

<script>
    const options = {
        cabang: [
            'Basket Putra',
            'Basket Putri',
            'Futsal Putra',
            'Voli Putra',
            'Badminton Ganda Putra',
            'Badminton Tunggal Putra',
            'Badminton Ganda Campuran',
            'E-sport',
            'Poster',
            'Lukis',
            'Dance',
            'Fotografi'
        ],
        house: [
            'House of Elixir',
            'House of Justicia',
            'House of Mercator',
            'House of Praxis',
            'House of Arcana',
            'House of Fortis',
            'House of Vivens',
            'House of Creatio',
            'House of Vitalis'
        ]
    };

    const filterBy    = document.getElementById('filter_by');
    const searchBox   = document.getElementById('search');
    const currentSearch = "{{ request('search') }}";

    function updateOptions(selectedFilter, selectedValue = null) {
        // Toggle tanggal vs select
        if (selectedFilter === 'tanggal') {
            searchBox.classList.add('hidden');
            return;
        }

        searchBox.classList.remove('hidden');
        searchBox.innerHTML = '';

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '-- Pilih --';
        placeholder.disabled = true;
        placeholder.selected = !selectedValue;
        searchBox.appendChild(placeholder);

        (options[selectedFilter] || []).forEach(opt => {
            const el = document.createElement('option');
            el.value = opt;
            el.textContent = opt;
            if (selectedValue && opt === selectedValue) {
                el.selected = true;
            }
            searchBox.appendChild(el);
        });
    }

    // Inisialisasi saat halaman load
    updateOptions(filterBy.value, currentSearch || null);

    // Update saat combo box 1 berubah
    filterBy.addEventListener('change', function () {
        updateOptions(this.value);
    });
</script>

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>

@endsection