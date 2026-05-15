@extends('layouts.sidebar')

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
                                <form action="{{ route('cabanglomba.updateStatus', $schedule->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status"
                                            onchange="this.form.submit()"
                                            class="bg-white text-black text-center px-2 py-1 rounded">
                                        <option value="Finished" {{ $finished ? 'selected' : '' }} >
                                            Finished
                                        </option>
                                        <option value="Not Finished" {{ !$finished ? 'selected' : '' }}>
                                            Not Finished
                                        </option>
                                    </select>                                                                              
                                </form>      
                            @else
                                <span class="text-sm uppercase tracking-widest text-white/70 mb-2 mt-2 text-center">
                                    {{ $schedule->phase }}
                                </span>
                                <form action="{{ route('cabanglomba.updateStatus', $schedule->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status"
                                            onchange="this.form.submit()"
                                            class="bg-white text-black text-center px-2 py-1 rounded">
                                        <option value="Finished" {{ $finished ? 'selected' : '' }} >
                                            Finished
                                        </option>
                                        <option value="Not Finished" {{ !$finished ? 'selected' : '' }}>
                                            Not Finished
                                        </option>
                                    </select>                                                                              
                                </form>    
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
        </section>

        <div class=" border-t border-white/10 mb-6"></div>

        @if ($finished)
        <h2 class="text-xl text-center font-heading font-bold text-white uppercase tracking-widest mb-6">
            Score            
        </h2>
        <div id="score" class="mt-4 mb-6">
            <form action="{{ route('cabanglomba.updateScore', $schedule->id ) }}" method="post">
                @csrf
                @method('PUT')
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl w-full mt-6 overflow-hidden">
                    {{-- HEADER --}}
                    <div class="grid grid-cols-3 bg-white/5 text-xs sm:text-sm uppercase text-white">
                        <div class="py-4 px-2 text-center text-yellow-500 font-bold break-words">
                            {{ $homeTeam->name ?? '-' }}
                        </div>
                        <div class="py-4 px-2 text-center text-yellow-500 font-bold">
                            Round
                        </div>
                        <div class="py-4 px-2 text-center text-yellow-500 font-bold break-words">
                            {{ $awayTeam->name ?? '-' }}
                        </div>
                    </div>
                    {{-- BODY --}}
                    <div class="divide-y divide-white/10">
                        @php 
                        if (in_array($schedule->competition, ['Badminton Tunggal Putra', 'Badminton Ganda Putra','Badminton Ganda Campuran'])) {
                            $roundsCount = 3;
                        } elseif (in_array($schedule->competition, ['Basket Putra', 'Basket Putri'])) {
                            $roundsCount = 4;
                        } elseif ($schedule->competition === 'Futsal Putra') {
                            $roundsCount = 0;
                        } elseif ($schedule->competition === 'Voli Putra') {
                            $roundsCount = 3;
                        } elseif ($schedule->competition === 'E-sport') {
                            $roundsCount = 2;
                        }        
                        @endphp
                        <input type="hidden" name="roundsCount" value={{ $roundsCount }}>
                        @for($i = 1; $i <= $roundsCount; $i++)
                        <div class="grid grid-cols-3 items-center hover:bg-white/5 transition">
                            {{-- HOME --}}
                            <div class="py-3 px-2 flex justify-center">
                                <input 
                                    type="number" min="0"step="1"
                                    name="score_home[{{ $i }}]"
                                    value="{{ $rounds->where('round_no', $i)->first()->home_score ?? '0' }}"
                                    class="w-full max-w-[70px] sm:max-w-[90px] px-2 sm:px-3 py-2
                                        text-sm sm:text-base text-center text-white bg-white/10 border border-white/20
                                        rounded-lg outline-none backdrop-blur-md transition">
                            </div>
                            {{-- ROUND --}}
                            <div class="py-3 px-2 text-center font-bold text-sm sm:text-base">
                                {{ format($i) }}
                            </div>
                            {{-- AWAY --}}
                            <div class="py-3 px-2 flex justify-center">
                                <input 
                                    type="number" min="0" step="1"
                                    name="score_away[{{ $i }}]"
                                    value="{{ $rounds->where('round_no', $i)->first()->away_score ?? '0' }}"
                                    class="w-full max-w-[70px] sm:max-w-[90px] px-2 sm:px-3 py-2
                                        text-sm sm:text-base text-center text-white bg-white/10 border border-white/20
                                        rounded-lg outline-none backdrop-blur-md transition">
                            </div>
                        </div>
                        @endfor
                        {{-- TOTAL --}}
                        <div class="grid grid-cols-3 items-center hover:bg-white/5 transition">
                            {{-- HOME TOTAL --}}
                            <div class="py-3 px-2 flex justify-center">
                                <input 
                                    type="number" min="0" step="1"
                                    name="total_score_home"
                                    value="{{ $homeTeam->pivot->total_score ?? 0 }}"
                                    class="w-full max-w-[70px] sm:max-w-[90px] px-2 sm:px-3 py-2 text-yellow-500 font-bold
                                        text-sm sm:text-base text-center bg-white/10 border border-white/20
                                        rounded-lg outline-none backdrop-blur-md transition">
                            </div>
                            {{-- LABEL --}}
                            <div class="py-3 px-2 text-center text-yellow-500 font-bold  text-sm sm:text-base">
                                Total
                            </div>
                            {{-- AWAY TOTAL --}}
                            <div class="py-3 px-2 flex justify-center">
                                <input 
                                    type="number" min="0" step="1"
                                    name="total_score_away"
                                    value="{{ $awayTeam->pivot->total_score ?? 0 }}"
                                    class="w-full max-w-[70px] sm:max-w-[90px] px-2 sm:px-3 py-2 text-yellow-500 font-bold
                                        text-sm sm:text-base text-center text-white bg-white/10 border border-white/20
                                        rounded-lg outline-none backdrop-blur-md transition">
                            </div>
                        </div>
                    </div>                                  
                </div>   
                <div class="flex justify-end">
                    <button class="inline-flex items-center gap-2 px-5 py-2 text-white
                                bg-blue-600 hover:bg-blue-500 rounded-lg transition
                                shadow-lg shadow-blue-600/20 border border-blue-400/20 mt-4">
                            <span class="font-bold font-['Georgia'] text-sm sm:text-base">Submit Score</span>
                    </button>
                </div>
            </form>        
        </div>
        @if (in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'E-sport']))
            <div class=" border-t border-white/10 mb-6 mt-4"></div>
            <h2 class="text-xl text-center font-heading font-bold text-white uppercase tracking-widest mb-6">
                Summary            
            </h2>
            <div id="summary" class="mt-4">
                <form action="{{ route('cabanglomba.updateSummary', $schedule->id ) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div id="summary" class="{{ in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'E-sport']) ? 'flex' : 'hidden' }} items-center justify-center w-full gap-3">
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
                                            'two_point_success'     => '2 Points Success',
                                            'two_point_failed'      => '2 Points Failed',
                                            'three_point_success'   => '3 Points Success',
                                            'three_point_failed'    => '3 Points Failed',
                                            'free_throw_success'    => 'Free Throws Success',
                                            'free_throw_failed'     => 'Free Throws Failed',
                                            'rebound_offensive'     => 'Rebounds Offensive',
                                            'rebound_defensive'     => 'Rebounds Defensive',
                                            'assist'                => 'Assist',
                                            'steal'                 => 'Steals',
                                            'block'                 => 'Blocks',
                                            'turnover'              => 'Turnovers',
                                            'foul'                  => 'Fouls',
                                            'points_off_turnover'   => 'Points Off Turnover',
                                        ];
                                    } elseif ($schedule->competition == 'Futsal Putra') {
                                        $statsName = [
                                            'foul'          => 'Fouls',
                                            'yellow_card'   => 'Yellow Cards',
                                            'red_card'      => 'Red Cards'
                                        ];
                                    } elseif ($schedule->competition == 'E-sport') {
                                        $statsName = [ 'mvp_id' => 'MVP' ];
                                    } 
                                @endphp
                                <input type="hidden" name="summaryCount" value={{ count($statsName) }}>
                                <input type="hidden" name="homeTeamId" value={{ $homeTeam->id }}>
                                <input type="hidden" name="awayTeamId" value={{ $awayTeam->id }}>
                                <!-- Body -->
                                <div class="divide-y divide-white/10">
                                    @foreach ($statsName as $realStat => $statName)
                                    <div class="grid grid-cols-3 items-center hover:bg-white/5 transition">
                                        <!-- Left -->
                                        @if($schedule->competition != 'E-sport')
                                        <div class="py-3 px-2 flex justify-center">
                                            <input 
                                                type="number" min="0"step="1"
                                                name="summary_home[{{ $realStat }}]"                                            
                                                value="{{ $homeTeamSummary->$realStat ?? '0' }}"
                                                class="w-full max-w-[70px] sm:max-w-[90px] px-2 sm:px-3 py-2
                                                    text-sm sm:text-base text-center text-white bg-white/10 border border-white/20
                                                    rounded-lg outline-none backdrop-blur-md transition">
                                        </div>
                                        @elseif ($schedule->competition = 'E-sport')
                                        <div class="py-3 px-2 flex justify-center">
                                            <select
                                                name="summary_home[{{ $realStat }}]"
                                                class="w-full max-w-[180px] px-2 sm:px-3 py-2
                                                    text-sm sm:text-base text-center 
                                                    bg-white/10 border border-white/20
                                                    rounded-lg outline-none backdrop-blur-md transition">
                                                <option class="text-white" disabled selected value="">--Select Player--</option>
                                                @foreach($homeTeamPlayers as $player)
                                                    <option class="text-black"
                                                        value="{{ $player->id }}"
                                                        {{ ($homeTeamSummary?->{$realStat} ?? null) == $player->id ? 'selected' : '' }}>
                                                        {{ $player->name }} ({{ $player->nrp }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>    
                                        @endif
                                        <!-- Center -->
                                        <div class="py-4 text-center text-base font-bold text-yellow-300">
                                            {{ $statName }}
                                        </div>
                                        <!-- Right -->
                                        @if($schedule->competition != 'E-sport')
                                        <div class="py-3 px-2 flex justify-center">
                                            <input required
                                                type="number" min="0"step="1"
                                                name="summary_away[{{ $realStat }}]"
                                                value="{{ $awayTeamSummary->$realStat ?? '0' }}"
                                                class="w-full max-w-[70px] sm:max-w-[90px] px-2 sm:px-3 py-2
                                                    text-sm sm:text-base text-center text-white bg-white/10 border border-white/20
                                                    rounded-lg outline-none backdrop-blur-md transition">
                                        </div>
                                        @elseif ($schedule->competition = 'E-sport')
                                        <div class="py-3 px-2 flex justify-center">
                                            <select required
                                                name="summary_away[{{ $realStat }}]"
                                                class="w-full max-w-[180px] px-2 sm:px-3 py-2
                                                    text-sm sm:text-base text-center 
                                                    bg-white/10 border border-white/20
                                                    rounded-lg outline-none backdrop-blur-md transition">
                                                <option class="text-white" disabled selected value="">--Select Player--</option>
                                                @foreach($awayTeamPlayers as $player)
                                                    <option class="text-black"
                                                        value="{{ $player->id }}"
                                                        {{ ($awayTeamSummary?->{$realStat} ?? null) == $player->id ? 'selected' : '' }}>
                                                        {{ $player->name }} ({{ $player->nrp }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>    
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="flex justify-end ">
                        <button class="inline-flex items-center gap-2 px-5 py-2 text-white
                                    bg-blue-600 hover:bg-blue-500 rounded-lg transition
                                    shadow-lg shadow-blue-600/20 border border-blue-400/20 mt-4">
                                <span class="font-bold font-['Georgia'] text-sm sm:text-base">Submit Summary</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
        @if (in_array($schedule->competition, ['Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 'E-sport']))
            <div class="border-t border-white/10 mb-6 mt-4"></div>
            <h2 class="text-xl text-center font-heading font-bold text-white uppercase tracking-widest mb-6">
                Stats            
            </h2>
            <div id="stats" class="mt-4">
                <h2 class="text-lg font-heading font-bold text-white uppercase tracking-widest mb-4">
                    {{ $homeTeam->name }}            
                </h2>
                <!-- tabel pemain home -->                
                <div id="statsHome" class="flex flex-col justify-center w-full gap-3 mb-6">
                    <form action="{{ route('cabanglomba.updateStats', $schedule->id ) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                            <div class="overflow-x-auto w-full">
                                <table class="w-full table-fixed text-base text-white">
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
                                    <input type="hidden" name="homeTeamId" value={{ $homeTeam->id }}>          
                                    <tbody class="divide-y divide-white/10">
                                        @forelse($homeTeamPlayers as $player)
                                        <tr class="hover:bg-white/5 transition">
                                            @if(in_array($schedule->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                                            <td class="w-[140px] px-2 py-4 text-center">{{ $player->pivot->back_number }}</td>
                                            @endif
                                            <td class="w-[140px] px-4 py-4 text-center">
                                                <div class="flex items-center gap-3 whitespace-nowrap">
                                                    <img src="{{ file_exists('assets/foto_peserta/'.$player->nrp.'.JPG')
                                                        ? asset('assets/foto_peserta/'.$player->nrp.'.JPG')
                                                        : asset('assets/icons/default.jpg') }}"
                                                class="w-10 h-10 rounded-full object-cover shrink-0">
                                                    <span class="whitespace-nowrap">{{ $player->name }}</span>
                                                </div>
                                            </td>                                        
                                            @foreach($statsName as $statName => $label)
                                            <td class="w-[140px] px-2 py-4 text-center">
                                            @if($statName == "minute_play")
                                                @php
                                                    $value = $homePlayerStats[$player->id]->minute_play ?? null;
                                                    $value = $value ? \Carbon\Carbon::parse($value)->format('i:s') : '00:00';
                                                @endphp
                                                <input
                                                    type="text" pattern="[0-9]{1,3}:[0-5][0-9]" placeholder="mm:ss"
                                                    name="home_stats[{{ $player->id }}][{{ $statName }}]"
                                                    value="{{ $value }}"
                                                    class="w-full max-w-[70px] mx-auto px-2 py-1 text-sm text-center text-white 
                                                    bg-white/10 border border-white/20 rounded-lg outline-none backdrop-blur-md transition">
                                            @else
                                            <input required type="number" min="0" step="1" 
                                                name="home_stats[{{ $player->id }}][{{ $statName }}]" 
                                                value="{{ $homePlayerStats[$player->id]->$statName ?? 0 }}" 
                                                class="w-full max-w-[70px] mx-auto px-2 py-1 text-sm text-center text-white 
                                                bg-white/10 border border-white/20 rounded-lg outline-none backdrop-blur-md transition">
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
                                            <td class="px-2 py-4 w-20 text-center text-yellow-500 font-bold">{{ $totalHomeStats[$key] }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="flex justify-end ">
                            <button class="inline-flex items-center gap-2 px-5 py-2 text-white
                                        bg-blue-600 hover:bg-blue-500 rounded-lg transition
                                        shadow-lg shadow-blue-600/20 border border-blue-400/20 mt-4">
                                    <span class="font-bold font-['Georgia'] text-sm sm:text-base">Submit Home Team Stats</span>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- tabel pemain away -->
                 <h2 class="text-lg font-heading font-bold text-white uppercase tracking-widest mb-4">
                {{ $awayTeam->name }}            
                </h2>
                <div id="statsAway" class="flex flex-col justify-center w-full gap-3">
                    <form action="{{ route('cabanglomba.updateStats', $schedule->id ) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                            <div class="overflow-x-auto w-full">
                                <table class="w-full table-fixed text-base text-white">
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
                                    <input type="hidden" name="awayTeamId" value={{ $awayTeam->id }}>     
                                    <tbody class="divide-y divide-white/10">
                                        @forelse($awayTeamPlayers as $player)
                                        <tr class="hover:bg-white/5 transition">
                                            @if(in_array($schedule->competition, ['Futsal Putra', 'Basket Putra', 'Basket Putri', 'Voli Putra']))
                                            <td class="w-[140px] px-2 py-4 text-center">{{ $player->pivot->back_number }}</td>
                                            @endif
                                            <td class="w-[140px] px-4 py-4 text-center">
                                                <div class="flex items-center gap-3 whitespace-nowrap">
                                                    <img src="{{ file_exists('assets/foto_peserta/'.$player->nrp.'.JPG')
                                                        ? asset('assets/foto_peserta/'.$player->nrp.'.JPG')
                                                        : asset('assets/icons/default.jpg') }}"
                                                class="w-10 h-10 rounded-full object-cover shrink-0">
                                                    <span class="whitespace-nowrap">{{ $player->name }}</span>
                                                </div>
                                            </td>
                                            @foreach($statsName as $statName => $label)
                                            <td class="w-[140px] px-2 py-4 text-center">
                                            @if($statName == "minute_play")
                                                @php
                                                    $value = $awayPlayerStats[$player->id]->minute_play ?? null;
                                                    $value = $value ? \Carbon\Carbon::parse($value)->format('i:s') : '00:00';
                                                @endphp
                                                <input
                                                    type="text" pattern="[0-9]{1,3}:[0-5][0-9]" placeholder="mm:ss"
                                                    name="away_stats[{{ $player->id }}][{{ $statName }}]"
                                                    value="{{ $value }}"
                                                    class="w-full max-w-[70px] mx-auto px-2 py-1 text-sm text-center text-white 
                                                    bg-white/10 border border-white/20 rounded-lg outline-none backdrop-blur-md transition">
                                            @else
                                            <input required type="number" min="0" step="1" 
                                                name="away_stats[{{ $player->id }}][{{ $statName }}]" 
                                                value="{{ $awayPlayerStats[$player->id]->$statName ?? 0 }}" 
                                                class="w-full max-w-[70px] mx-auto px-2 py-1 text-sm text-center text-white 
                                                bg-white/10 border border-white/20 rounded-lg outline-none backdrop-blur-md transition">
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
                                            <td class="px-2 py-4 w-20 text-center text-yellow-500 font-bold">{{ $totalAwayStats[$key] }}</td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end ">
                        <button class="inline-flex items-center gap-2 px-5 py-2 text-white
                                   bg-blue-600 hover:bg-blue-500 rounded-lg transition
                                   shadow-lg shadow-blue-600/20 border border-blue-400/20 mt-4">
                               <span class="font-bold font-['Georgia'] text-sm sm:text-base">Submit Away Team Stats</span>
                        </button>
                    </div>
                </form>
            </div>   
        </div>
        @endif
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
                    @if(!$schedule->is_finished)
                    <div class="mt-2">
                        <form action="{{ route('cabanglomba.updateStatus', $schedule->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="status"
                                    onchange="this.form.submit()"
                                    class="bg-white text-black text-center px-2 py-1 rounded">
                                <option value="Finished" {{ $schedule->is_finished ? 'selected' : '' }} >
                                    Finished
                                </option>
                                <option value="Not Finished" {{ !$schedule->is_finished ? 'selected' : '' }}>
                                    Not Finished
                                </option>
                            </select>                                                                              
                        </form>  
                    </div>
                    @endif
                </div>
                {{-- BARIS BAWAH: Venue & Time (Turun ke bawah) --}}
                <div class="w-full border-t border-white/10 mt-4"></div>
                <div class="flex items-center justify-center w-full">
                    <div class="text-base text-yellow-300 text-center leading-relaxed tracking-wide mt-4">
                        @if(!$schedule->is_finished)
                            {{ $schedule->venue }} <br> {{ date('H.i', strtotime($schedule->time)) }} WIB
                        @else
                            <form action="{{ route('cabanglomba.updateStatus', $schedule->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="bg-white text-black text-center px-2 py-1 rounded">
                                    <option value="Finished" {{ $schedule->is_finished ? 'selected' : '' }} >
                                        Finished
                                    </option>
                                    <option value="Not Finished" {{ !$schedule->is_finished ? 'selected' : '' }}>
                                        Not Finished
                                    </option>
                                </select>                                                                              
                            </form>     
                        @endif
                    </div>
                </div>
            </div>            
        </section>

        {{-- DIVIDER --}}
        <div class=" border-t border-white/10 mb-6"></div>
        @if($schedule->is_finished)
        <div class="flex items-center justify-center w-full gap-3">
            <form action="{{ route('cabanglomba.updateScore', $schedule->id ) }}" method="post" class="w-full">
                @csrf
                @method('PUT')
                <div class="bg-black/60 backdrop-blur-md border border-white/10 rounded-2xl shadow-xl overflow-hidden w-full">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full table-fixed text-base text-white">                            
                            <thead class="bg-white/5 text-sm uppercase tracking-widest">
                                <tr>
                                    <th class="px-4 py-4 text-yellow-500 text-center text-lg font-bold">
                                        Participants
                                    </th>
                                    @if ($schedule->is_finished)
                                    <th class="w-24 px-6 py-4 text-yellow-500 text-center text-lg font-bold">
                                        Points
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <input type="hidden" name="roundsCount" value="0">
                            <tbody class="divide-y divide-white/10">
                                @forelse($participants as $participant)
                                    @php
                                        $getHouseName = function($teamName){
                                            if(!$teamName) return null;
                                            return explode(' ', trim($teamName))[0];
                                        };
                                        $participantHouse = $getHouseName($participant->name);
                                        $logo = ($participantHouse && isset($houseLogos[$participantHouse])) ? $houseLogos[$participantHouse] : 'default.png';
                                    @endphp
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="px-4 py-4 w-full">
                                            <div class="flex items-center justify-center gap-3 w-full">
                                                <img src="{{ asset('assets/fakultas/' . $logo) }}" class="w-10 h-10 object-contain shrink-0">
                                                <span class="text-white font-bold text-base uppercase tracking-wide truncate">
                                                    {{ $participant->name }}
                                                </span>
                                            </div>
                                        </td>

                                        @if ($schedule->is_finished)
                                        <td class="w-24 px-6 py-4 text-center">
                                            <input required type="number" min="0" step="1"
                                                name="seniScore[{{ $participant->id }}]"
                                                value="{{ $participant->pivot->total_score ?? 0 }}"
                                                class="w-full max-w-[70px] mx-auto px-1 py-1 text-sm text-center text-white 
                                                bg-white/10 border border-white/20 rounded-lg outline-none 
                                                backdrop-blur-md transition">
                                        </td>
                                        @endif
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

                <div class="flex justify-end">
                    <button class="inline-flex items-center gap-2 px-5 py-2 text-white
                                bg-blue-600 hover:bg-blue-500 rounded-lg transition
                                shadow-lg shadow-blue-600/20 border border-blue-400/20 mt-4">
                        <span class="font-bold font-['Georgia'] text-sm sm:text-base">Submit Score</span>
                    </button>
                </div>
            </form>
        </div>
        @endif
        @endif       
    </div>
</section>    



<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>

@endsection