@extends('layouts.app')

@section('content')

<section class="w-full px-4 sm:px-6 mb-36">
    <div class="w-full max-w-6xl mx-auto">
        {{-- ================= HEADER ================= --}}
        <section class="mb-10">
            <header class="mb-6">
                <h2 class="text-xl sm:text-2xl text-center font-heading font-bold text-white uppercase tracking-widest">
                    Schedule Details
                </h2>
            </header>
        </section>
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
        @if ($schedule->type === 'Pertandingan')
        <!-- match details -->
        <section class="mb-6">      
            <div class="bg-black/300 py-4 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mb-6">
                <div class="overflow-x-auto">
                    @php
                        $finished  = $schedule->is_finished;
                        $homeTeam = $schedule->teams->where('pivot.home_away', 'Home')->first();
                        $awayTeam = $schedule->teams->where('pivot.home_away', 'Away')->first();
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
                    {{-- BARIS ATAS: Tim Home, Score/VS, Tim Away --}}
                    <div class="grid grid-cols-3 items-center w-full">    
                        {{-- HOME --}}
                        <div class="flex flex-col items-center gap-3 px-8">
                            <img src="{{ asset('assets/fakultas/' . $logoHome) }}" 
                                class="w-20 h-20 object-contain">
                            <span class="text-white font-bold text-sm uppercase tracking-wide text-center">
                                {{ $homeTeam->name }}
                            </span>
                        </div>
                        {{-- MIDDLE --}}
                        <div class="flex flex-col items-center justify-center px-8">
                            <span class="text-base text-yellow-500 font-bold uppercase tracking-widest mb-1 text-center">
                                {{ $schedule->competition }}
                            </span>
                            @if($finished)
                                <span class="text-sm uppercase tracking-widest text-white/70 mb-2 text-center">
                                    {{ $schedule->phase }}
                                </span>
                            @endif
                            <div class="flex items-center justify-center gap-3 min-h-[40px]">
                                @if($finished)
                                    <span class="text-2xl font-bold text-yellow-500">
                                        {{ $homeTeam->pivot->total_score }}
                                    </span>                                
                                @endif
                                <span class="text-white/30 text-2xl">VS</span>
                                @if($finished)
                                    <span class="text-2xl font-bold text-yellow-500">
                                        {{ $awayTeam->pivot->total_score }}
                                    </span>                                
                                @endif
                            </div>
                            @if($finished)
                                <span class="text-sm text-white uppercase mt-2">
                                    Finished
                                </span>
                            @else
                                <span class="text-sm uppercase tracking-widest text-white/70 mb-2 mt-2 text-center">
                                    {{ $schedule->phase }}
                                </span>
                            @endif
                        </div>
                        {{-- AWAY --}}
                        <div class="flex flex-col items-center gap-3 px-8">
                            <img src="{{ asset('assets/fakultas/' . $logoAway) }}" 
                                class="w-20 h-20 object-contain">
                            <span class="text-white font-bold text-sm uppercase tracking-wide text-center">
                                {{ $awayTeam->name }}
                            </span>
                        </div>
                    </div>            
                </div>         
                <div class=" border-t border-white/10 mt-4 mb-4"></div>
                <div class="items-center justify-center w-full gap-3">
                    <div class="text-lg font-bold text-white text-center leading-relaxed tracking-wide">
                        {{ $schedule->venue }} 
                    </div>
                    <div class="text-base text-yellow-300 text-center leading-relaxed tracking-wide">
                        {{ convertToDate($schedule->time) }} <br>
                        {{ date('H.i', strtotime($schedule->time)) }} WIB
                    </div>
                </div>       
            </div>            
            @if ($finished && in_array($schedule->competition, [
                'Basket Putra', 
                'Basket Putri', 
                'Voli Putra', 
                'E-sport',
                'Badminton Tunggal Putra',
                'Badminton Ganda Putra',
                'Badminton Ganda Campuran'
            ]))
            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mt-6 overflow-hidden">
                {{-- HEADER --}}
                <div class="grid grid-cols-3 bg-white/5 text-sm uppercase text-white">                    
                    <div class="py-4 text-center text-yellow-500 font-bold">
                        {{ $homeTeam->name ?? '-' }}
                    </div>
                    <div class="py-4 text-center text-yellow-500 font-bold">
                        Round
                    </div>
                    <div class="py-4 text-center text-yellow-500 font-bold">
                        {{ $awayTeam->name ?? '-' }}
                    </div>
                </div>
                {{-- BODY --}}
                <div class="divide-y divide-white/10">
                    @for($i = 1; $i <= count($rounds); $i++)
                    <div class="grid grid-cols-3 hover:bg-white/5 transition">
                        <div class="py-4 text-center text-white">
                            {{ $rounds->where('round_no', $i)->first()->home_score ?? '-' }}
                        </div>
                        <div class="py-4 text-center font-bold">
                            {{ format($i) }}
                        </div>
                        <div class="py-4 text-center text-white">
                            {{ $rounds->where('round_no', $i)->first()->away_score ?? '-' }}
                        </div>
                    </div>
                    @endfor
                    {{-- TOTAL --}}
                    <div class="grid grid-cols-3 hover:bg-white/5 transition">
                        <div class="py-4 text-center font-bold text-yellow-500">
                            {{ $homeTeam->pivot->total_score ?? '-' }}
                        </div>
                        <div class="py-4 text-center font-bold">
                            Total
                        </div>
                        <div class="py-4 text-center font-bold text-yellow-500">
                            {{ $awayTeam->pivot->total_score ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>

        {{-- DIVIDER --}}
        <div class=" border-t border-white/10 mb-6"></div>
        
        @if(in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'E-sport']))
        <div class="flex w-full gap-3  mb-6">
            <button id="summaryButton" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                    bg-blue-600 hover:bg-blue-500 border border-blue-400/20
                    shadow-lg shadow-blue-600/20 transition"
                    onclick=switchTab('summary')>
                <span class="text-sm font-bold text-white uppercase tracking-widest">
                    Summary
                </span>
            </button>
            <button id="statsButton" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                    bg-white/10 hover:bg-white/20 border border-white/20
                    shadow-lg shadow-black/20 backdrop-blur-md transition"
                    onclick=switchTab('stats')>
                <span class="text-sm font-bold text-white uppercase tracking-widest">
                    Stats
                </span>
            </button>
        </div>      
        <div id="summary" class="{{ in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'E-sport']) ? 'flex' : 'hidden' }} items-center justify-center w-full gap-3">
            @if ($schedule->competition !== 'E-sport')
            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="w-full overflow-hidden rounded-2xl border border-white/10 bg-black/60 backdrop-blur-md shadow-xl">
                    <!-- Header -->
                    <div class="grid grid-cols-3 bg-white/5 text-sm uppercase tracking-widest">
                        <div class="py-4 text-center text-base font-bold text-yellow-500">
                            {{ $homeTeam->name ?? '-' }}
                        </div>
                        <div class="py-4 text-center text-base font-bold text-yellow-500">
                            Stats
                        </div>
                        <div class="py-4 text-center text-base font-bold text-yellow-500">
                            {{ $awayTeam->name ?? '-' }}
                        </div>
                    </div>
                    @php
                    $statsName = [];
                        if ($schedule->competition == 'Basket Putra' || $schedule->competition == 'Basket Putri') {
                            $statsName = [
                                'Field Goals',
                                '2 Points',
                                '3 Points',
                                'Free Throws',
                                'Rebounds (O/D)',
                                'Assist',
                                'Steals',
                                'Blocks',
                                'Turnovers',
                                'Fouls',
                                'Points Off Turnover'
                            ];
                        } elseif ($schedule->competition == 'Futsal Putra') {
                            $statsName = [
                                'Goals',
                                'Fouls',
                                'Yellow Cards',
                                'Red Cards'
                            ];
                        } 
                    @endphp
                    <!-- Body -->
                    <div class="divide-y divide-white/10">
                        @foreach ($statsName as $stat)
                        <div class="grid grid-cols-3 items-center hover:bg-white/5 transition">
                            <!-- Left -->
                            <div class="py-4 pl-4 text-left text-base text-white">
                                {{ $homeTeamSummary[$stat] ?? "-"}}
                            </div>
                            <!-- Center -->
                            <div class="py-4 text-center text-base font-bold text-yellow-300">
                                {{ $stat }}
                            </div>
                            <!-- Right -->
                            <div class="py-4 pr-4 text-right text-base text-white">
                                {{ $awayTeamSummary[$stat] ?? "-"}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>    
            @elseif($schedule->competition === 'E-sport')
            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mt-6 overflow-hidden">
                <h2 class="text-xl font-heading font-bold text-white tracking-widest text-left px-6 py-4 mt-2">
                    MVPs
                </h2>      
                @php
                    if (isset($homeTeamSummary['MVP']) && isset($awayTeamSummary['MVP'])) {
                        $homeMVP = $homeTeamPlayers->firstWhere('id', $homeTeamSummary['MVP']);
                        $awayMVP = $awayTeamPlayers->firstWhere('id', $awayTeamSummary['MVP']);
                    }
                @endphp       
                <div class=" border-t border-white/10 mb-4"></div>
                @if($schedule->is_finished && $homeTeamSummary && $awayTeamSummary)
                <div class="flex flex-col gap-2 mb-4 px-6">
                    <p class="text-white text-base text-yellow-500 font-bold tracking-wide">Home MVP:</p>
                    <div class="flex items-center gap-3">
                        <img 
                            src="https://my.ubaya.ac.id/img/mhs/{{ $homeMVP->nrp }}_l.jpg"
                            class="w-10 h-10 rounded-full object-cover shrink-0">
                        <span class="text-white text-base tracking-wide">
                            {{ $homeMVP->name }}
                        </span>
                    </div>
                </div>
                <div class="flex flex-col gap-2 mb-4 px-6">
                    <p class="text-white text-base text-yellow-500 font-bold tracking-wide">Away MVP:</p> 
                    <div class="flex items-center gap-3">
                        <img 
                            src="https://my.ubaya.ac.id/img/mhs/{{ $awayMVP->nrp }}_l.jpg"
                            class="w-10 h-10 rounded-full object-cover shrink-0">   
                        <span class="text-white text-base tracking-wide">
                            {{ $awayMVP->name }} 
                        </span> 
                    </div>
                </div> 
                @else
                <div class="flex flex-col gap-2 mb-4 px-6">
                    <div class="flex items-center gap-3">
                        <span class="text-white text-base tracking-wide">
                            Pertandingan belum selesai
                        </span> 
                    </div>
                </div> 
                @endif
            </div>          
            @endif
        </div>
        @elseif($schedule->competition === 'Voli Putra')
        <h2 class="text-xl text-center font-heading font-bold text-white uppercase tracking-widest">
            Stats
        </h2>
        @endif
        @if (in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'E-sport', 'Voli Putra']))
        <div id="stats" class="{{ $schedule->competition === 'Voli Putra' ? 'flex flex-col' : 'hidden' }}  items-center justify-center w-full">
            <div class=" border-t border-white/10 mb-6"></div>
            <div class="flex w-full gap-3  mb-6">
                <button id="homeTeamButton" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl
                        bg-blue-600 hover:bg-blue-500 border border-blue-400/20
                        shadow-lg shadow-blue-600/20 transition"
                        onclick=switchTeam('home')>
                    <span class="text-sm font-bold text-white uppercase tracking-widest">
                        {{ $homeTeam->name ?? '-' }} 
                    </span>
                </button>
                <button id="awayTeamButton" class="flex-1 inline-flex items-center justify-center px-5 py-3 rounded-xl
                        bg-white/10 hover:bg-white/20 border border-white/20
                        shadow-lg shadow-black/20 backdrop-blur-md transition"
                        onclick=switchTeam('away')>
                    <span class="text-sm font-bold text-white uppercase tracking-widest">
                        {{ $awayTeam->name ?? '-' }}        
                    </span>
                </button>
            </div>    
            <!-- tabel pemain home -->
            <div id="statsHome" class="flex flex-col justify-center w-full gap-3">
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                            @php
                            if ($schedule->competition == 'Basket Putra' || $schedule->competition == 'Basket Putri') {
                                $statsName = [
                                    'minute_play' => 'Min',
                                    'point'       => 'Pts',
                                    'assist'      => 'Ast',
                                    'rebound'     => 'Reb',
                                    'steal'       => 'Stl',
                                    'block'       => 'Blk',
                                    'turnover'    => 'TO',
                                    'foul'        => 'Foul',
                                ];
                            } else if ($schedule->competition == 'Futsal Putra') {
                                $statsName = [
                                    'point'       => 'Goal',
                                    'yellow_card' => 'Yellow Card',
                                    'red_card'    => 'Red Card',
                                ];
                            } else if ($schedule->competition == 'E-sport') {
                                $statsName = [
                                    'kill_count'  => 'Kill',
                                    'death_count' => 'Death',
                                    'assist'      => 'Assist',
                                ];
                            } else if ($schedule->competition == 'Voli Putra') {
                                $statsName = [
                                    'point'       => 'Score',
                                    'service_ace' => 'Service Ace',
                                    'block'       => 'Block',
                                ];
                            }
                            @endphp
                            <thead class="bg-white/5 text-sm uppercase tracking-widest">
                                <tr>
                                    @if(in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra']))
                                    <th class="w-[140px] px-4 py-4 text-yellow-500 text-center font-bold">No</th>
                                    @endif
                                    <th class="w-[140px] px-2 py-4 text-yellow-500 text-center font-bold">Name</th>
                                    @foreach($statsName as $col)                                            
                                    <th class="w-[140px] px-2 py-4 text-yellow-500 text-center font-bold">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse($homeTeamPlayers as $player)
                                <tr class="hover:bg-white/5 transition">
                                    @if(in_array($schedule->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                                    <td class="w-[140px] px-2 py-4 text-center">{{ $player->pivot->back_number }}</td>
                                    @endif
                                    <td class="w-[140px] px-4 py-4 text-center">
                                        <div class="flex items-center gap-3 whitespace-nowrap">
                                            <img src="https://my.ubaya.ac.id/img/mhs/{{ $player->nrp }}_l.jpg" 
                                                class="w-10 h-10 rounded-full object-cover shrink-0">
                                            <span class="whitespace-nowrap">{{ $player->name }}</span>
                                        </div>
                                    </td>                                        
                                    @foreach($statsName as $statName => $label)
                                    <td class="w-[140px] px-2 py-4 text-center">
                                    @if($statName == "minute_play")
                                        @php
                                            $value = $homePlayerStats[$player->id]->minute_play ?? null;
                                            $value = $value ? \Carbon\Carbon::parse($value)->format('i:s') : '-';
                                        @endphp
                                        {{ $value }}
                                    @else
                                        {{ $homePlayerStats[$player->id]->$statName ?? "-" }}
                                    @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-white" colspan="{{ count($statsColumns) }}">
                                        Tidak ada pemain
                                    </td>
                                </tr>
                                @endforelse
                                {{-- TOTAL --}}
                                <tr>
                                    @if(in_array($schedule->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                                    <td colspan="2" class="px-2 py-4 text-center text-yellow-500 font-bold">Total</td>
                                    @else
                                    <td class="px-2 py-4 text-center text-yellow-500 font-bold">Total</td>
                                    @endif
                                    @foreach($statsName as $key=>$stat)
                                    <td class="px-2 py-4 w-20 text-center text-yellow-500 font-bold">{{ $totalHomeStats[$key] ?? "-"}}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>                      
                </div>  
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mt-6 overflow-hidden">
                    <h2 class="text-xl font-heading font-bold text-white tracking-widest text-left px-6 py-4 mt-2">
                        Crews
                    </h2>             
                    <div class=" border-t border-white/10 mb-4"></div>
                    @forelse($homeTeamCrews as $crew)
                    <div class="flex items-center gap-2 mb-4 px-6">
                        <img 
                            src="{{ (isset($crew->nrp) && strlen($crew->nrp) == 9)
                                ? 'https://my.ubaya.ac.id/img/mhs/' . $crew->nrp . '_l.jpg'
                                : asset('assets/icons/default.jpg') }}"
                                
                            style="width:40px; height:40px;"
                            class="rounded-full object-cover shrink-0">
                        <span class="text-white text-base tracking-wide">
                            {{ $crew->name }} 
                        </span> 
                        <span class="text-yellow-500 font-bold text-base tracking-wide">
                            ({{ $crew->pivot->role }})
                        </span> 
                    </div>
                    @empty
                    <div class="text-white text-center px-6 py-4">
                        Tidak ada crew  
                    </div>
                    @endforelse
                </div>                
            </div>
            <!-- tabel pemain away -->
            <div id="statsAway" class="hidden flex flex-col justify-center w-full gap-3">
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                            <thead class="bg-white/5 text-sm uppercase tracking-widest">
                                <tr>
                                    @if(in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra']))
                                    <th class="w-[140px] px-4 py-4 text-yellow-500 text-center font-bold">No</th>
                                    @endif
                                    <th class="w-[140px] px-2 py-4 text-yellow-500 text-center font-bold">Name</th>
                                    @foreach($statsName as $col)
                                    <th class="w-[140px] px-2 py-4 text-yellow-500 text-center font-bold">{{ $col }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse($awayTeamPlayers as $player)
                                <tr class="hover:bg-white/5 transition">
                                    @if(in_array($schedule->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                                    <td class="w-[140px] px-2 py-4 text-center">{{ $player->pivot->back_number }}</td>
                                    @endif
                                    <td class="w-[140px] px-4 py-4 text-center">
                                        <div class="flex items-center gap-3 whitespace-nowrap">
                                            <img src="https://my.ubaya.ac.id/img/mhs/{{ $player->nrp }}_l.jpg" 
                                                class="w-10 h-10 rounded-full object-cover shrink-0">
                                            <span class="whitespace-nowrap">{{ $player->name }}</span>
                                        </div>
                                    </td>
                                    @foreach($statsName as $statName => $label)
                                    <td class="w-[140px] px-2 py-4 text-center">
                                    @if($statName == "minute_play")
                                        @php
                                            $value = $awayPlayerStats[$player->id]->minute_play ?? null;
                                            $value = $value ? \Carbon\Carbon::parse($value)->format('i:s') : '-';
                                        @endphp
                                        {{ $value }}
                                    @else
                                    {{ $awayPlayerStats[$player->id]->$statName ?? "-" }}
                                    @endif   
                                    </td>                    
                                    @endforeach
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-white" colspan="{{ count($statsColumns) }}">
                                        Tidak ada pemain
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    @if(in_array($schedule->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                                    <td colspan="2" class="px-2 py-4 text-center text-yellow-500 font-bold">Total</td>
                                    @else
                                    <td class="px-2 py-4 text-center text-yellow-500 font-bold">Total</td>
                                    @endif
                                    @foreach($statsName as $key=>$stat)
                                    <td class="px-2 py-4 w-20 text-center text-yellow-500 font-bold">{{ $totalAwayStats[$key] ?? "-" }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>                      
                </div>     
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mt-6 overflow-hidden">
                    <h2 class="text-xl font-heading font-bold text-white tracking-widest text-left px-6 py-4 mt-2">
                        Crews
                    </h2>             
                    <div class=" border-t border-white/10 mb-4"></div>
                    @forelse($awayTeamCrews as $crew)
                    <div class="flex items-center gap-2 mb-4 px-6">
                        <img 
                            src="{{ (isset($crew->nrp) && strlen($crew->nrp) == 9)
                                ? 'https://my.ubaya.ac.id/img/mhs/' . $crew->nrp . '_l.jpg'
                                : asset('assets/icons/default.jpg') }}"                                
                            style="width:40px; height:40px;"
                            class="rounded-full object-cover shrink-0">
                        <span class="text-white text-base tracking-wide">
                            {{ $crew->name }} 
                        </span> 
                        <span class="text-yellow-500 font-bold text-base tracking-wide">
                            ({{ $crew->pivot->role }})
                        </span> 
                    </div>
                    @empty
                    <div class="text-white text-center px-6 py-4">
                        Tidak ada crew  
                    </div>
                    @endforelse
                </div>
            </div>  
        </div>   
        @elseif(in_array($schedule->competition, ['Badminton Tunggal Putra', 'Badminton Ganda Putra', 'Badminton Ganda Campuran']))
        <h2 class="text-xl text-center font-heading font-bold text-white uppercase tracking-widest mb-6">
            Players            
        </h2>
            <div class="flex w-full gap-3  mb-6">
                <button id="homeBadminButton" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                        bg-blue-600 hover:bg-blue-500 border border-blue-400/20
                        shadow-lg shadow-blue-600/20 transition"
                        onclick=switchTeam('homeBadmin')>
                    <span class="text-sm font-bold text-white uppercase tracking-widest">
                        {{ $homeTeam->name ?? '-' }} 
                    </span>
                </button>
                <button id="awayBadminButton" class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl
                        bg-white/10 hover:bg-white/20 border border-white/20
                        shadow-lg shadow-black/20 backdrop-blur-md transition"
                        onclick=switchTeam('awayBadmin')>
                    <span class="text-sm font-bold text-white uppercase tracking-widest">
                        {{ $awayTeam->name ?? '-' }}        
                    </span>
                </button>
            </div>    
            <!-- tabel pemain home -->
            <div id="homeBadmin" class="flex flex-col justify-center w-full gap-3">
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                            <thead class="bg-white/5 text-sm uppercase tracking-widest">
                                <tr>
                                    <th class="px-4 py-4 text-yellow-500 text-center font-bold">Name</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse($homeTeamPlayers as $player)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-4 py-4"> 
                                        <div class="flex items-center justify-center gap-3">
                                            <img 
                                                src="https://my.ubaya.ac.id/img/mhs/{{ $player->nrp }}_l.jpg"
                                                style="width:40px; height:40px;"
                                                class="rounded-full object-cover shrink-0">
                                            <span class="leading-none">
                                                {{ $player->name }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-white" colspan="6">
                                        Tidak ada pemain
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>                      
                </div>  
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mt-6 overflow-hidden">
                    <h2 class="text-xl font-heading font-bold text-white tracking-widest text-left px-6 py-4 mt-2">
                        Crews
                    </h2>             
                    <div class=" border-t border-white/10 mb-4"></div>
                    @forelse($homeTeamCrews as $crew)
                    <div class="flex items-center gap-2 mb-4 px-6">
                        <img 
                            src="{{ (isset($crew->nrp) && strlen($crew->nrp) == 9)
                                ? 'https://my.ubaya.ac.id/img/mhs/' . $crew->nrp . '_l.jpg'
                                : asset('assets/icons/default.jpg') }}"
                                
                            style="width:40px; height:40px;"
                            class="rounded-full object-cover shrink-0">
                        <span class="text-white text-base tracking-wide">
                            {{ $crew->name }} 
                        </span> 
                        <span class="text-yellow-500 font-bold text-base tracking-wide">
                            ({{ $crew->pivot->role }})
                        </span> 
                    </div>
                    @empty
                    <div class="text-white text-center px-6 py-4">
                        Tidak ada crew  
                    </div>
                    @endforelse
                </div>                
            </div>
            <!-- tabel pemain away -->
            <div id="awayBadmin" class="hidden flex flex-col justify-center w-full gap-3">
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                    <div class="overflow-x-auto">
                        <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                            <thead class="bg-white/5 text-sm uppercase tracking-widest">
                                <tr>
                                    <th class="px-4 py-4 text-yellow-500 text-center font-bold">Name</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @forelse($awayTeamPlayers as $player)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="px-4 py-4"> 
                                        <div class="flex items-center justify-center gap-3">
                                            <img 
                                                src="https://my.ubaya.ac.id/img/mhs/{{ $player->nrp }}_l.jpg"
                                                style="width:40px; height:40px;"
                                                class="rounded-full object-cover shrink-0">
                                            <span class="leading-none">
                                                {{ $player->name }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-white" colspan="7">
                                        Tidak ada pemain
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>                
                </div>    
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mt-6 overflow-hidden">
                    <h2 class="text-xl font-heading font-bold text-white tracking-widest text-left px-6 py-4 mt-2">
                        Crews
                    </h2>             
                    <div class=" border-t border-white/10 mb-4"></div>
                    @forelse($awayTeamCrews as $crew)
                    <div class="flex items-center gap-2 mb-4 px-6">
                        <img 
                            src="{{ (isset($crew->nrp) && strlen($crew->nrp) == 9)
                                ? 'https://my.ubaya.ac.id/img/mhs/' . $crew->nrp . '_l.jpg'
                                : asset('assets/icons/default.jpg') }}"
                                
                            style="width:40px; height:40px;"
                            class="rounded-full object-cover shrink-0">
                        <span class="text-white text-base tracking-wide">
                            {{ $crew->name }} 
                        </span> 
                        <span class="text-yellow-500 font-bold text-base tracking-wide">
                            ({{ $crew->pivot->role }})
                        </span> 
                    </div>
                    @empty
                    <div class="text-white text-center px-6 py-4">
                        Tidak ada crew  
                    </div>
                    @endforelse
                </div>
            </div>
        @endif
        @elseif ($schedule->type === 'Perlombaan')
        <!-- match details -->
        <section class="mb-6">      
            <div class="bg-black/300 py-4 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full mb-6">
                {{-- LAYOUT PERLOMBAAN --}}
                <div class="flex flex-col items-center justify-center w-full px-4">
                    <span class="text-base text-yellow-500 font-bold text-center uppercase tracking-widest text-white mb-1">
                        {{ $schedule->competition }}
                    </span>
                    <span class="text-white text-center text-2xl font-bold tracking-wide">{{ $schedule->name }}</span>
                </div>

                {{-- BARIS BAWAH: Venue & Time (Turun ke bawah) --}}
                <div class="w-full border-t border-white/10 mt-4"></div>
                <div class="flex items-center justify-center w-full">
                    <div class="text-base text-yellow-300 text-center leading-relaxed tracking-wide mt-4">
                        @if(!$schedule->is_finished)
                            {{ $schedule->venue }} <br> {{ date('H.i', strtotime($schedule->time)) }} WIB
                        @else
                            FINISHED
                        @endif
                    </div>
                </div>
            </div>            
        </section>

        {{-- DIVIDER --}}
        <div class=" border-t border-white/10 mb-6"></div>

        <div class="flex items-center justify-center w-full gap-3">
            <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-base text-white whitespace-nowrap" style="min-width: max-content;">
                        <thead class="bg-white/5 text-sm uppercase tracking-widest">
                            <tr>
                                <th class="px-4 py-4 text-yellow-500 text-center text-lg font-bold">Participants</th>
                                @if ($schedule->is_finished)
                                    <th class="px-4 py-4 text-yellow-500 text-center text-lg font-bold">Points</th>
                                    @php
                                    $participants = $participants->sortByDesc(function($p) {
                                        return $p->pivot->total_score ?? 0;
                                    });
                                    @endphp
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10" x-data="{ activeRow: null }">
                            @forelse($participants as $participant)
                                @php
                                    $getHouseName = function($teamName) {
                                        if (!$teamName) return null;
                                        return explode(' ', trim($teamName))[0];
                                    };
                                    $participantHouse = $getHouseName($participant->name);
                                    $logo = ($participantHouse && isset($houseLogos[$participantHouse])) 
                                            ? $houseLogos[$participantHouse] 
                                            : 'default.png';
                                    $teamPlayers = $participant->participants()->get();
                                    $teamCrews = $participant->crews()->get();
                                @endphp
                                <!-- MAIN ROW -->
                                <tr
                                    @click="activeRow = activeRow === {{ $participant->id }} ? null : {{ $participant->id }}"
                                    class="hover:bg-white/5 transition cursor-pointer"
                                >
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <img 
                                                src="{{ asset('assets/fakultas/' . $logo) }}"
                                                class="w-10 h-10 object-contain shrink-0">

                                            <span class="text-white font-bold text-base uppercase tracking-wide">
                                                {{ $participant->name }}
                                            </span>
                                        </div>
                                    </td>
                                    @if ($schedule->is_finished)
                                        <td class="px-4 py-4 text-center text-yellow-500 font-bold whitespace-nowrap">
                                            {{ $participant->pivot->total_score ?? '-' }} 
                                        </td>
                                    @endif
                                </tr>
                                <!-- COLLAPSIBLE ROW -->
                                <tr
                                    x-show="activeRow === {{ $participant->id }}"
                                    x-transition
                                    class="bg-white/5"
                                >
                                    <td colspan="{{ $schedule->is_finished ? 2 : 1 }}"
                                        class="px-4">
                                        <div class="border-t border-white/20">
                                            {{-- PLAYERS --}}
                                            @foreach($teamPlayers as $player)
                                                <div class="flex items-center justify-center gap-2 mt-4">
                                                    <img 
                                                        src="https://my.ubaya.ac.id/img/mhs/{{ $player->nrp }}_l.jpg"
                                                        style="width:40px; height:40px;"
                                                        class="rounded-full object-cover shrink-0">
                                                    <span class="leading-none text-base text-white">
                                                        {{ $player->name }}
                                                    </span>
                                                </div>
                                            @endforeach
                                            {{-- CREWS --}}
                                            @foreach($teamCrews as $crew)
                                                <div class="flex items-center justify-center gap-2 mt-4">
                                                    <img 
                                                        src="{{ (isset($crew->nrp) && strlen($crew->nrp) == 9)
                                                            ? 'https://my.ubaya.ac.id/img/mhs/' . $crew->nrp . '_l.jpg'
                                                            : asset('assets/icons/default.jpg') }}"
                                                        style="width:40px; height:40px;"
                                                        class="rounded-full object-cover shrink-0">
                                                    <span class="leading-none text-base text-white">
                                                        {{ $crew->name }}
                                                    </span>
                                                    <span class="leading-none text-base text-yellow-500 font-bold">
                                                        ({{ $crew->pivot->role }})
                                                    </span>
                                                </div>
                                            @endforeach
                                            <div class="mb-4"></div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-4 py-4 text-center text-white">
                                        Tidak ada participant
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>                
            </div>    
        </div> 
        @endif              
</section>    

{{-- 3. FOOTER (Pindahkan ke luar div konten) --}}
<div class="w-full mt-auto">
    @include('layouts.footer')
</div>   

<script>
    function switchTab(tab) {
        const summaryTab = document.getElementById('summary');
        const statsTab = document.getElementById('stats');
        const summaryButton = document.getElementById('summaryButton');
        const statsButton = document.getElementById('statsButton');
        if (tab === 'summary') {
            summaryTab.classList.add('block');
            summaryTab.classList.remove('hidden');
            statsTab.classList.add('hidden');
            statsTab.classList.remove('block');
            summaryButton.classList.add('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            summaryButton.classList.remove('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
            statsButton.classList.add('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
            statsButton.classList.remove('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');   
        } else {
            summaryTab.classList.add('hidden');
            summaryTab.classList.remove('block');
            statsTab.classList.add('block');
            statsTab.classList.remove('hidden');
            summaryButton.classList.add('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
            summaryButton.classList.remove('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            statsButton.classList.add('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            statsButton.classList.remove('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md'); 
        }
    }

    function switchTeam(team) {
        const statsHome = document.getElementById('statsHome');
        const statsAway = document.getElementById('statsAway');
        const homeTeamButton = document.getElementById('homeTeamButton');
        const awayTeamButton = document.getElementById('awayTeamButton');           
        const homeBadminButton = document.getElementById('homeBadminButton');
        const awayBadminButton = document.getElementById('awayBadminButton');
        const homeBadminTab = document.getElementById('homeBadmin');
        const awayBadminTab = document.getElementById('awayBadmin');
        if (team === 'home') {
            statsHome.classList.add('block');
            statsHome.classList.remove('hidden');
            statsAway.classList.add('hidden');
            statsAway.classList.remove('block');
            homeTeamButton.classList.add('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            homeTeamButton.classList.remove('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
            awayTeamButton.classList.add('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');     
            awayTeamButton.classList.remove('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');    
        } else if (team === 'away') {
            statsHome.classList.add('hidden');
            statsHome.classList.remove('block');
            statsAway.classList.add('block');
            statsAway.classList.remove('hidden');
            homeTeamButton.classList.add('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
            homeTeamButton.classList.remove('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            awayTeamButton.classList.add('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            awayTeamButton.classList.remove('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
        } else if (team === 'homeBadmin') {
            homeBadminTab.classList.add('block');
            homeBadminTab.classList.remove('hidden');
            awayBadminTab.classList.add('hidden');
            awayBadminTab.classList.remove('block');
            homeBadminButton.classList.add('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            homeBadminButton.classList.remove('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
            awayBadminButton.classList.add('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');     
            awayBadminButton.classList.remove('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');    
        } else if (team === 'awayBadmin') {
            awayBadminTab.classList.add('block');
            awayBadminTab.classList.remove('hidden');  
            homeBadminTab.classList.add('hidden');
            homeBadminTab.classList.remove('block');
            awayBadminButton.classList.add('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            awayBadminButton.classList.remove('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
            homeBadminButton.classList.remove('bg-blue-600', 'hover:bg-blue-500', 'border-blue-400/20', 'shadow-blue-600/20');
            homeBadminButton.classList.add('bg-white/10', 'hover:bg-white/20', 'border-white/20', 'shadow-black/20', 'backdrop-blur-md');
        }
    }
</script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>

@endsection