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

            {{-- COMBO BOX 1: Filter By --}}
            <select id="filter_by" name="filter_by"
                    class="bg-black/60 border border-white/10 text-white rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-white/30">
                <option value="" disabled {{ !request('filter_by') ? 'selected' : '' }}>-- Filter By --</option>
                <option value="cabang"  {{ request('filter_by') === 'cabang'  ? 'selected' : '' }}>Cabang Lomba</option>
                <option value="house"   {{ request('filter_by') === 'house'   ? 'selected' : '' }}>House</option>
                <option value="tanggal" {{ request('filter_by') === 'tanggal' ? 'selected' : '' }}>Tanggal</option>
            </select>

            {{-- COMBO BOX 2 / Date Input --}}
            <select id="search" name="search"
                    class="flex-1 bg-black/60 border border-white/10 text-white rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-1 focus:ring-white/30
                           {{ request('filter_by') === 'tanggal' ? 'hidden' : '' }}"
                    style="box-sizing: border-box; font-size: 0.875rem;">
            </select>

            <input type="date" id="input-tanggal" name="tanggal"
                   value="{{ request('tanggal') }}"
                   onclick="this.showPicker()"
                   class="flex-1 bg-black/60 border border-white/10 text-white rounded-lg px-4 py-[9px] focus:outline-none focus:ring-1 focus:ring-white/30 text-sm
                          {{ request('filter_by') === 'tanggal' ? '' : 'hidden' }}" 
                   style="color-scheme: dark;" />

            {{-- BUTTON SEARCH --}}
            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/10 text-white text-sm font-semibold transition">
                Search
            </button>

            {{-- BUTTON CLEAR --}}
            @if(request('search') || request('tanggal'))
                <a href="{{ route('schedule') }}"
                   class="inline-flex items-center justify-center px-5 py-2 rounded-lg bg-white/5 hover:bg-white/10 border border-white/10 text-white/60 text-sm font-semibold transition">
                    Clear
                </a>
            @endif

        </form>


        {{-- ================= SCHEDULE LIST ================= --}}

        @php
            // ---- DUMMY DATA ----
            $schedules = [
                [
                    'date_label' => 'Sabtu, 16 Mei 2026',
                    'competitions' => [
                        [
                            'name' => 'E-Sport',
                            'matches' => [
                                [
                                    'team_home'  => 'FORTIS 1',
                                    'team_away'  => 'JUSTICIA 2',
                                    'house_home' => 'Fortis',
                                    'house_away' => 'Justicia',
                                    'score_home' => 2,
                                    'score_away' => 0,
                                    'phase'      => 'Group Phase',
                                    'venue'      => 'SGFK',
                                    'time'       => '13.00 WIB',
                                ],
                                [
                                    'team_home'  => 'ELIXIR 1',
                                    'team_away'  => 'ARCANA 1',
                                    'house_home' => 'Elixir',
                                    'house_away' => 'Arcana',
                                    'score_home' => 1,
                                    'score_away' => 2,
                                    'phase'      => 'Group Phase',
                                    'venue'      => 'SGFBE',
                                    'time'       => '13.00 WIB',
                                ],
                            ],
                        ],
                        [
                            'name' => 'Basket Putri',
                            'matches' => [
                                [
                                    'team_home'  => 'FORTIS',
                                    'team_away'  => 'MERCATOR 2',
                                    'house_home' => 'Fortis',
                                    'house_away' => 'Mercator',
                                    'score_home' => 67,
                                    'score_away' => 52,
                                    'phase'      => 'Semifinal',
                                    'venue'      => 'UBAYA Sports Center',
                                    'time'       => '13.00 WIB',
                                ],
                                [
                                    'team_home'  => 'ELIXIR',
                                    'team_away'  => 'JUSTICIA',
                                    'house_home' => 'Elixir',
                                    'house_away' => 'Justicia',
                                    'score_home' => 30,
                                    'score_away' => 46,
                                    'phase'      => 'Semifinal',
                                    'venue'      => 'UBAYA Sports Center',
                                    'time'       => '15.00 WIB',
                                ],
                            ],
                        ],
                        [
                            'name' => 'Futsal Putra',
                            'matches' => [
                                [
                                    'team_home'  => 'VIVENS',
                                    'team_away'  => 'PRAXIS',
                                    'house_home' => 'Vivens',
                                    'house_away' => 'Praxis',
                                    'score_home' => null,
                                    'score_away' => null,
                                    'phase'      => 'Group Phase',
                                    'venue'      => 'GOR UBAYA',
                                    'time'       => '16.00 WIB',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'date_label' => 'Minggu, 17 Mei 2026',
                    'competitions' => [
                        [
                            'name' => 'Basket Putra',
                            'matches' => [
                                [
                                    'team_home'  => 'ARCANA',
                                    'team_away'  => 'VITALIS',
                                    'house_home' => 'Arcana',
                                    'house_away' => 'Vitalis',
                                    'score_home' => null,
                                    'score_away' => null,
                                    'phase'      => 'Group Phase',
                                    'venue'      => 'UBAYA Sports Center',
                                    'time'       => '09.00 WIB',
                                ],
                                [
                                    'team_home'  => 'CREATIO',
                                    'team_away'  => 'MERCATOR',
                                    'house_home' => 'Creatio',
                                    'house_away' => 'Mercator',
                                    'score_home' => null,
                                    'score_away' => null,
                                    'phase'      => 'Group Phase',
                                    'venue'      => 'UBAYA Sports Center',
                                    'time'       => '11.00 WIB',
                                ],
                            ],
                        ],
                        [
                            'name' => 'Voli Putra',
                            'matches' => [
                                [
                                    'team_home'  => 'FORTIS',
                                    'team_away'  => 'ELIXIR',
                                    'house_home' => 'Fortis',
                                    'house_away' => 'Elixir',
                                    'score_home' => null,
                                    'score_away' => null,
                                    'phase'      => 'Final',
                                    'venue'      => 'GOR UBAYA',
                                    'time'       => '14.00 WIB',
                                ],
                            ],
                        ],
                    ],
                ],
            ];
            // ---- END DUMMY DATA ----

            // House color map for avatar circles (Tetap dipertahankan untuk referensi warna lain jika butuh)
            $houseColors = [
                'Fortis'   => '#b45309',
                'Justicia' => '#b91c1c',
                'Mercator' => '#0369a1',
                'Praxis'   => '#4d7c0f',
                'Arcana'   => '#6d28d9',
                'Elixir'   => '#0f766e',
                'Vivens'   => '#0e7490',
                'Creatio'  => '#be185d',
                'Vitalis'  => '#15803d',
            ];

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

        @forelse($schedules as $day)
        {{-- DATE HEADER --}}
        <div class="mb-12">
            <h3 class="text-lg font-heading font-bold text-white uppercase tracking-widest mb-6 mt-6">
                {{ $day['date_label'] }}
            </h3>

            {{-- Loop masuk ke level Kompetisi (Basket, Futsal, dll) --}}
            @foreach($day['competitions'] as $competition)
                <div class="mb-8">
                    <table class="w-full text-base text-white bg-gray-900 shadow-xl rounded-2xl" style="min-width: 300px;">
                        <thead class="bg-white/5 uppercase tracking-widest text-sm">
                            <tr>
                                <th class="px-6 py-4 text-lg text-center font-bold text-yellow-400"> 
                                    {{ $competition['name'] }} 
                                </th>
                            </tr>
                        </thead>

                        {{-- BODY: Daftar Pertandingan --}}
                        <tbody class="divide-y divide-white/10 text-base bg-black/20">
                            @foreach ($competition['matches'] as $match)
                                @php
                                    $finished  = !is_null($match['score_home']);
                                    $logoHome  = $houseLogos[$match['house_home']] ?? 'default.png';
                                    $logoAway  = $houseLogos[$match['house_away']] ?? 'default.png';
                                @endphp
                                <tr>
                                    <td class="px-2 py-4 w-full border-t border-white/50 my-3" >
                                        {{-- WRAPPER UTAMA: Berbaris ke bawah (Kolom) --}}
                                        <div class="flex flex-col items-center gap-3 w-full">
                                            
                                            {{-- BARIS ATAS: Tim Home, Score/VS, Tim Away --}}
                                            <div class="flex items-center justify-between gap-3 w-full">
                                                
                                                {{-- LOGO & NAMA HOME --}}
                                                <div class="flex flex-col items-center flex-1 gap-3">
                                                    <img src="{{ asset('assets/fakultas/' . $logoHome) }}" 
                                                        class="w-12 h-12 object-contain flex-shrink-0">
                                                    <span class="text-white text-center font-bold text-l uppercase tracking-wide">
                                                        {{ $match['team_home'] }}
                                                    </span>
                                                </div>

                                                {{-- SCORE / VS (Tengah) --}}
                                                <div class="flex flex-col items-center justify-center min-w-[140px]">
                                                    <span class="text-sm text-center uppercase tracking-widest text-white/70 mb-1">
                                                        {{ $match['phase'] }}
                                                    </span>

                                                    @if($finished)
                                                        <div class="flex items-center gap-3">
                                                            <span class="text-2xl text-center font-bold" style="color: #eab308;">{{ $match['score_home'] }}</span>
                                                            <span class="text-white/30 text-2xl">VS</span>
                                                            <span class="text-2xl text-center font-bold" style="color: #eab308;">{{ $match['score_away'] }}</span>
                                                        </div>
                                                        <span class="text-sm text-white text-center uppercase tracking-tighter mt-2">Finished</span>
                                                    @else                                                
                                                        <span class="text-white/30 text-2xl">VS</span>
                                                    @endif    
                                                </div>

                                                {{-- NAMA & LOGO AWAY --}}
                                                <div class="flex flex-col items-center justify-end flex-1 gap-3 text-right">                                                
                                                    <img src="{{ asset('assets/fakultas/' . $logoAway) }}" 
                                                        class="w-12 h-12 object-contain flex-shrink-0">
                                                    <span class="text-white text-center font-bold text-l uppercase tracking-wide">
                                                        {{ $match['team_away'] }}
                                                    </span>
                                                </div>

                                            </div>

                                            {{-- BARIS BAWAH: Venue & Time (Turun ke bawah) --}}
                                            @if(!$finished)
                                                <div class="w-full border-t border-white/10 my-3"></div>
                                                <div class="flex items-center justify-center w-full">
                                                    <span class="text-[5px] text-white text-center leading-relaxed tracking-wide">
                                                        {{ $match['venue'] }} ({{ $match['time'] }})
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
            @endforeach
        </div>

        {{-- Divider antar hari --}}
        @if (!$loop->last)
            <div class="my-12 border-t border-white/10 mb-6"></div>
        @endif

    @empty
        <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl px-6 py-12 text-center">
            <p class="text-white/50 text-base">Tidak ada jadwal yang ditemukan.</p>
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
            'E-sport'
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
    const inputTanggal = document.getElementById('input-tanggal');
    const currentSearch = "{{ request('search') }}";

    function updateOptions(selectedFilter, selectedValue = null) {
        // Toggle tanggal vs select
        if (selectedFilter === 'tanggal') {
            searchBox.classList.add('hidden');
            inputTanggal.classList.remove('hidden');
            return;
        }

        searchBox.classList.remove('hidden');
        inputTanggal.classList.add('hidden');
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