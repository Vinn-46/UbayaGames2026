@extends('layouts.sidebar')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">

        {{-- ================= HEADER ================= --}}
        <section class="mb-2">
            <header>
                <h2 class="text-xl text-center sm:text-2xl font-heading font-bold text-white uppercase tracking-widest">
                    Recap
                </h2>
            </header>
        </section>

        {{-- TEKS SELAMAT DATANG (Sudah benar) --}}
        <div class="text-[#CBDCC1] font-['Georgia'] text-sm sm:text-base text-right mb-4">
            Selamat Datang, 
            <span class="text-white font-bold">
                {{ Auth::user()->username ?? 'Admin' }}
            </span>
        </div>

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

            {{-- ================= FILTER BAR ================= --}}
            <form method="get" action="{{ route('cabanglomba.showRecap') }}" class="mb-6 flex flex-col sm:flex-row gap-3">

                <select name="competition" required
                class="flex-1 bg-black/60 border border-white/10 text-white rounded-lg px-4 py-3 text-m focus:outline-none focus:ring-1 focus:ring-white/30">
                    <option value="" disabled {{ !request('competition') ? 'selected' : '' }}>-- Pilih Cabang Lomba --</option>
                    <option value="Basket Putra" {{ request('competition') == 'Basket Putra' ? 'selected' : '' }}>Basket Putra</option>
                    <option value="Basket Putri" {{ request('competition') == 'Basket Putri' ? 'selected' : '' }}>Basket Putri</option>
                    <option value="Futsal Putra" {{ request('competition') == 'Futsal Putra' ? 'selected' : '' }}>Futsal Putra</option>
                    <option value="Voli Putra" {{ request('competition') == 'Voli Putra' ? 'selected' : '' }}>Voli Putra</option>
                    <option value="E-sport" {{ request('competition') == 'E-sport' ? 'selected' : '' }}>E-sport</option>
                </select>

                <select name="type" required
                class="flex-1 bg-black/60 border border-white/10 text-white rounded-lg px-4 py-3 text-m focus:outline-none focus:ring-1 focus:ring-white/30">
                    <option value="" disabled {{ !request('type') ? 'selected' : '' }}>-- Pilih Tipe Rekap --</option>
                    <option value="team" {{ request('type') == 'team' ? 'selected' : '' }}>Per Tim</option>
                    <option value="player" {{ request('type') == 'player' ? 'selected' : '' }}>Per Pemain</option>
                </select>

                <button type="submit"
                        class="px-5 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/10 text-white text-sm font-semibold transition">
                    Search
                </button>
            </form>             
        </div>
        @error('noSummary')
            <div style="color:red; text-align:right" class="mb-6">
                {{ $message }}
            </div>
        @enderror
        <p class="{{ request()->query() ? 'hidden' : '' }} text-large text-center font-bold">
            Pilih jenis kompetisi dan tipe rekap terlebih dahulu
        </p>
        @if(request('type') === 'team')
        <div class=" {{ request('type') === 'team' ? '' : 'hidden' }} flex flex-col justify-center w-full gap-3">
            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        @php
                        $statsName = [
                            'team_name'   => 'Team Name',
                            'point'       => 'Goal',
                            'foul'        => 'Foul',
                            'yellow_card' => 'Yellow Card',
                            'red_card'    => 'Red Card',
                        ];
                        @endphp

                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                @foreach($statsName as $statName => $col)
                                <th class="w-[140px] px-2 py-4 text-yellow-500 text-center font-bold">
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort' => $statName,
                                        'direction' => request('direction') == 'desc' ? 'asc' : 'desc'
                                    ]) }}">
                                        {{ $col }}
                                    </a>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($teamsRecap as $team)
                            <tr class="hover:bg-white/5 transition">
                                @foreach($statsName as $statName => $label)
                                    @if($statName === 'team_name')
                                    <td class="w-[140px] px-4 py-4 text-center">
                                        <div class="flex items-center gap-3 whitespace-nowrap">
                                            @php
                                            $getHouseName = function($teamName) {
                                                if (!$teamName) return null;
                                                return explode(' ', trim($teamName))[0];
                                            };
                                            $house = $getHouseName($team['team_name']);
                                            $logo = $houseLogos[$house] ?? 'default.png';
                                            @endphp
                                            <img src="{{ asset('assets/fakultas/' . $logo) }}"
                                                class="w-10 h-10 rounded-full object-cover shrink-0">

                                            <span class="text-white font-bold text-base uppercase tracking-wide">
                                                {{ $team['team_name'] }}
                                            </span>
                                        </div>
                                    </td>
                                    @else
                                    <td class="w-[140px] px-2 py-4 text-center">
                                        {{ $team[$statName] ?? "-" }}
                                    </td>
                                    @endif
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($statsName) }}"
                                    class="px-4 py-4 text-center text-white">
                                    Tidak ada tim
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>                      
            </div>              
        </div>
        @elseif(request('type') === 'player')
        <div class=" {{ request('type') === 'player' ? '' : 'hidden' }} flex flex-col justify-center w-full gap-3">
            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        @php
                        if ($competition === 'Futsal Putra') {
                            $statsName = [
                                'player_name' => 'Player Name',
                                'team_name'   => 'Team Name',
                                'point'       => 'Goal',
                                'yellow_card' => 'Yellow Card',
                                'red_card'    => 'Red Card',
                            ];
                        }                        
                        elseif ($competition === 'Basket Putra' || $competition === 'Basket Putri') {
                            $statsName = [
                                'player_name' => 'Player Name',
                                'team_name'   => 'Team Name',
                                'point'       => 'Point',
                                'assist'      => 'Assist',
                                'rebound'     => 'Rebound',
                                'steal'       => 'Steal',
                            ];
                        }
                        elseif ($competition === 'Voli Putra') {
                            $statsName = [
                                'player_name' => 'Player Name',
                                'team_name'   => 'Team Name',
                                'point'       => 'Point',
                                'service_ace' => 'Service Ace',
                                'block'       => 'Block',
                            ];
                        }
                        elseif ($competition === 'E-sport') {
                            $statsName = [
                                'player_name' => 'Player Name',
                                'team_name'   => 'Team Name',
                                'kill_count'  => 'Kill',
                                'death_count' => 'Death',
                                'assist'      => 'Assist',
                                'mvp_count'   => 'MVP Count',
                            ];
                        }
                        @endphp
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                @foreach($statsName as $statName => $col)
                                <th class="w-[140px] px-2 py-4 text-yellow-500 text-center font-bold">
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort' => $statName,
                                        'direction' => request('direction') == 'desc' ? 'asc' : 'desc'
                                    ]) }}">
                                        {{ $col }}
                                    </a>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($allPlayersSummary as $player)
                            <tr class="hover:bg-white/5 transition">
                                @foreach($statsName as $statName => $label)
                                    @if($statName === 'player_name')
                                    <td class="w-[140px] px-4 py-4 text-center">
                                        <div class="flex items-center gap-3 whitespace-nowrap">
                                            <img src="{{ file_exists('assets/foto_peserta/'.$player['nrp'].'.JPG')
                                                        ? asset('assets/foto_peserta/'.$player['nrp'].'.JPG')
                                                        : asset('assets/icons/default.jpg') }}"
                                                class="w-10 h-10 rounded-full object-cover shrink-0">
                                            <span class="whitespace-nowrap">{{ $player['player_name'] }}</span>
                                        </div>
                                    </td>
                                    @else
                                    <td class="w-[140px] px-2 py-4 text-center">
                                        {{ $player[$statName] ?? "-" }}
                                    </td>
                                    @endif
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($statsName) }}"
                                    class="px-4 py-4 text-center text-white">
                                    Tidak ada tim
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>                      
            </div>              
        </div>
        @endif        
    </div>      
</section>       

<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>

@endsection