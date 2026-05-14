<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\StatisticTeam;
use App\Models\StatisticParticipant;
use App\Models\Rounds;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    
    public function show(Request $request)
    {
        $selectedDate = $request->query('date', now()->toDateString());

        $query = Schedule::with('teams')->whereDate('time', $selectedDate);        

        if ($request->filled('filter_by') && $request->filled('search')) {
            $filterBy = $request->filter_by;
            $search   = $request->search;

            if ($filterBy === 'cabang') {
                $query->where('competition', $search);
            } elseif ($filterBy === 'house') {
                $query->whereHas('teams', function ($q) use ($search) {
                    $q->where('name', 'LIKE', substr($search, 9) .'%');
                });
            }
        }

        $schedules = $query->orderBy('time', 'asc')->get();
        $groupedSchedules = $schedules->groupBy('competition')->sortKeys();
        
        return view('schedule', [
            'groupedSchedules'    => $groupedSchedules,
            'selectedDate' => $selectedDate
        ]);
    }    

    public function matchDetails(Schedule $schedule)
    {
        $schedule->load('teams'); // Pastikan untuk memuat relasi teams
        $rounds = $schedule->rounds()->orderBy('round_no')->get(); // Memuat rounds terkait dengan schedule
        $participants = $schedule->teams()->with('participants')->get(); // Memuat participants terkait dengan teams di schedule
        
        $homeTeam = $schedule->teams()
            ->wherePivot('home_away', 'Home')
            ->first();

        $awayTeam = $schedule->teams()
            ->wherePivot('home_away', 'Away')
            ->first();

        $homeTeamPlayers = ($homeTeam?->participants ?? collect())->sortBy('pivot.back_number');
        $awayTeamPlayers = ($awayTeam?->participants ?? collect())->sortBy('pivot.back_number');      
        $homeTeamCrews = $homeTeam?->crews ?? collect();
        $awayTeamCrews = $awayTeam?->crews ?? collect();        

        $homeTeamSummary = $homeTeam?->summary()->where('schedule_id', $schedule->id)->first();
        $awayTeamSummary = $awayTeam?->summary()->where('schedule_id', $schedule->id)->first();        

        $homeTeamSummaryShow = [];
        $awayTeamSummaryShow = [];
        if (($schedule->competition == 'Basket Putra' || $schedule->competition == 'Basket Putri') && $schedule->is_finished && $homeTeamSummary && $awayTeamSummary) {
            $homeTeamSummaryShow = [
                'Field Goals' => ($homeTeamSummary->two_point_success + $homeTeamSummary->three_point_success) . "/" .
                    ($homeTeamSummary->two_point_success + $homeTeamSummary->two_point_failed + $homeTeamSummary->three_point_success + $homeTeamSummary->three_point_failed) .
                    " (" . round((($homeTeamSummary->two_point_success + $homeTeamSummary->three_point_success) / max(1, ($homeTeamSummary->two_point_success + $homeTeamSummary->two_point_failed + $homeTeamSummary->three_point_success + $homeTeamSummary->three_point_failed))) * 100, 1) . "%)",

                '2 Points' => $homeTeamSummary->two_point_success . "/" .
                    ($homeTeamSummary->two_point_success + $homeTeamSummary->two_point_failed) .
                    " (" . round(($homeTeamSummary->two_point_success / max(1, ($homeTeamSummary->two_point_success + $homeTeamSummary->two_point_failed))) * 100, 1) . "%)",

                '3 Points' => $homeTeamSummary->three_point_success . "/" .
                    ($homeTeamSummary->three_point_success + $homeTeamSummary->three_point_failed) .
                    " (" . round(($homeTeamSummary->three_point_success / max(1, ($homeTeamSummary->three_point_success + $homeTeamSummary->three_point_failed))) * 100, 1) . "%)",

                'Free Throws' => $homeTeamSummary->free_throw_success . "/" .
                    ($homeTeamSummary->free_throw_success + $homeTeamSummary->free_throw_failed) .
                    " (" . round(($homeTeamSummary->free_throw_success / max(1, ($homeTeamSummary->free_throw_success + $homeTeamSummary->free_throw_failed))) * 100, 1) . "%)",

                'Rebounds (O/D)' => "(" . $homeTeamSummary->rebound_offensive . "/" . $homeTeamSummary->rebound_defensive . ")",

                'Assist' => $homeTeamSummary->assist,
                'Steals' => $homeTeamSummary->steal,
                'Blocks' => $homeTeamSummary->block,
                'Turnovers' => $homeTeamSummary->turnover,
                'Fouls' => $homeTeamSummary->foul,
                'Points Off Turnover' => $homeTeamSummary->points_off_turnover,
            ];

            $awayTeamSummaryShow = [
                'Field Goals' => ($awayTeamSummary->two_point_success + $awayTeamSummary->three_point_success) . "/" .
                    ($awayTeamSummary->two_point_success + $awayTeamSummary->two_point_failed + $awayTeamSummary->three_point_success + $awayTeamSummary->three_point_failed) .
                    " (" . round((($awayTeamSummary->two_point_success + $awayTeamSummary->three_point_success) / max(1, ($awayTeamSummary->two_point_success + $awayTeamSummary->two_point_failed + $awayTeamSummary->three_point_success + $awayTeamSummary->three_point_failed))) * 100, 1) . "%)",

                '2 Points' => $awayTeamSummary->two_point_success . "/" .
                    ($awayTeamSummary->two_point_success + $awayTeamSummary->two_point_failed) .
                    " (" . round(($awayTeamSummary->two_point_success / max(1, ($awayTeamSummary->two_point_success + $awayTeamSummary->two_point_failed))) * 100, 1) . "%)",

                '3 Points' => $awayTeamSummary->three_point_success . "/" .
                    ($awayTeamSummary->three_point_success + $awayTeamSummary->three_point_failed) .
                    " (" . round(($awayTeamSummary->three_point_success / max(1, ($awayTeamSummary->three_point_success + $awayTeamSummary->three_point_failed))) * 100, 1) . "%)",

                'Free Throws' => $awayTeamSummary->free_throw_success . "/" .
                    ($awayTeamSummary->free_throw_success + $awayTeamSummary->free_throw_failed) .
                    " (" . round(($awayTeamSummary->free_throw_success / max(1, ($awayTeamSummary->free_throw_success + $awayTeamSummary->free_throw_failed))) * 100, 1) . "%)",

                'Rebounds (O/D)' => "(" . $awayTeamSummary->rebound_offensive . "/" . $awayTeamSummary->rebound_defensive . ")",

                'Assist' => $awayTeamSummary->assist,
                'Steals' => $awayTeamSummary->steal,
                'Blocks' => $awayTeamSummary->block,
                'Turnovers' => $awayTeamSummary->turnover,
                'Fouls' => $awayTeamSummary->foul,
                'Points Off Turnover' => $awayTeamSummary->points_off_turnover,
            ];
        } elseif ($schedule->competition == 'Futsal Putra' && $schedule->is_finished && $homeTeamSummary && $awayTeamSummary) {
            $homeTeamSummaryShow = [
                'Goals' => $homeTeam->schedules()->where('schedule_id', $schedule->id)->first()?->pivot->total_score ?? 0,

                'Fouls' => $homeTeamSummary->foul,

                'Yellow Cards' => $homeTeamSummary->yellow_card,

                'Red Cards' => $homeTeamSummary->red_card,
            ];

            $awayTeamSummaryShow = [
                'Goals' => $awayTeam->schedules()->where('schedule_id', $schedule->id)->first()?->pivot->total_score ?? 0,

                'Fouls' => $awayTeamSummary->foul,

                'Yellow Cards' => $awayTeamSummary->yellow_card,

                'Red Cards' => $awayTeamSummary->red_card,
            ];
        } elseif ($schedule->competition == 'E-sport' && $schedule->is_finished && $homeTeamSummary && $awayTeamSummary) {
            $homeTeamSummaryShow = ['MVP' => $homeTeamSummary->mvp_id];
            $awayTeamSummaryShow = ['MVP' => $awayTeamSummary->mvp_id];
        }

        $homePlayerStats = $homeTeamPlayers->mapWithKeys(function ($p) use ($schedule) {
            return [
                $p->id => $p->stats()
                    ->where('schedule_id', $schedule->id)
                    ->first()
            ];
        });  
        $awayPlayerStats = $awayTeamPlayers->mapWithKeys(function ($p) use ($schedule) {
            return [
                $p->id => $p->stats()
                    ->where('schedule_id', $schedule->id)
                    ->first()
            ];
        });  

        $totalHomeStats = [];
        $totalAwayStats = [];

        if (in_array($schedule->competition, ['Basket Putra', 'Basket Putri'])) {
            $totalHomeStats = [
                'minute_play' => '-',
                'point'       => 0,
                'assist'      => 0,
                'rebound'     => 0,
                'steal'       => 0,
                'block'       => 0,
                'turnover'    => 0,
                'foul'        => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        } else if ($schedule->competition == 'Futsal Putra') {
            $totalHomeStats = [
                'point'       => 0,
                'yellow_card' => 0,
                'red_card'    => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        } else if ($schedule->competition == 'E-sport') {
            $totalHomeStats = [
                'kill_count'  => 0,
                'death_count' => 0,
                'assist'      => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        } else if ($schedule->competition == 'Voli Putra') {
            $totalHomeStats = [
                'point'       => 0,
                'service_ace' => 0,
                'block'       => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        }

        foreach ($homePlayerStats as $homePlayerStat) {
            if (!$homePlayerStat) continue;
            foreach ($totalHomeStats as $statsName => $totalStats) {
                if ($statsName == 'minute_play') continue;
                $totalHomeStats[$statsName] += $homePlayerStat->$statsName ?? 0;
            }
        }

        foreach ($awayPlayerStats as $awayPlayerStat) {
            if (!$awayPlayerStat) continue;
            foreach ($totalAwayStats as $statsName => $totalStats) {
                if ($statsName == 'minute_play') continue;
                $totalAwayStats[$statsName] += $awayPlayerStat->$statsName ?? 0;
            }
        }  

        return view('matchdetails', [
            'schedule' => $schedule,
            'rounds' => $rounds,
            'participants' => $participants,
            'homeTeamPlayers' => $homeTeamPlayers,
            'awayTeamPlayers' => $awayTeamPlayers,
            'homeTeamCrews' => $homeTeamCrews,
            'awayTeamCrews' => $awayTeamCrews,
            'homeTeamSummary' => $homeTeamSummaryShow,
            'awayTeamSummary' => $awayTeamSummaryShow,
            'homePlayerStats' => $homePlayerStats,
            'awayPlayerStats' => $awayPlayerStats,            
            'totalHomeStats' => $totalHomeStats,
            'totalAwayStats' => $totalAwayStats,
        ]);
    }

    public function showCablom(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != "Cabang Lomba") abort(404);

        $selectedDate = $request->query('date', now()->toDateString());

        $query = Schedule::with('teams')->whereDate('time', $selectedDate);        

        if ($request->filled('filter_by') && $request->filled('search')) {
            $filterBy = $request->filter_by;
            $search   = $request->search;

            if ($filterBy === 'cabang') {
                $query->where('competition', $search);
            } elseif ($filterBy === 'house') {
                $query->whereHas('teams', function ($q) use ($search) {
                    $q->where('name', 'LIKE', substr($search, 9) .'%');
                });
            }
        }

        $schedules = $query->orderBy('time', 'asc')->get();
        $groupedSchedules = $schedules->groupBy('competition')->sortKeys();
        
        return view('cabang-lomba', [
            'groupedSchedules'    => $groupedSchedules,
            'selectedDate' => $selectedDate
        ]);
    }  

    public function showCablomDetails(Schedule $schedule)
    {
        if (!Auth::check() || Auth::user()->role != "Cabang Lomba") abort(404);
            
        $schedule->load('teams'); // Pastikan untuk memuat relasi teams
        $rounds = $schedule->rounds()->orderBy('round_no')->get(); // Memuat rounds terkait dengan schedule
        $participants = $schedule->teams()->with('participants')->get(); // Memuat participants terkait dengan teams di schedule
        
        $homeTeam = $schedule->teams()
            ->wherePivot('home_away', 'Home')
            ->first();

        $awayTeam = $schedule->teams()
            ->wherePivot('home_away', 'Away')
            ->first();

        $homeTeamPlayers = ($homeTeam?->participants ?? collect())->sortBy('pivot.back_number');
        $awayTeamPlayers = ($awayTeam?->participants ?? collect())->sortBy('pivot.back_number');      
        $homeTeamCrews = $homeTeam?->crews ?? collect();
        $awayTeamCrews = $awayTeam?->crews ?? collect();        

        $homeTeamSummary = $homeTeam?->summary()->where('schedule_id', $schedule->id)->first();
        $awayTeamSummary = $awayTeam?->summary()->where('schedule_id', $schedule->id)->first();

        $homePlayerStats = $homeTeamPlayers->mapWithKeys(function ($p) use ($schedule) {
            return [
                $p->id => $p->stats()
                    ->where('schedule_id', $schedule->id)
                    ->first()
            ];
        });  
        $awayPlayerStats = $awayTeamPlayers->mapWithKeys(function ($p) use ($schedule) {
            return [
                $p->id => $p->stats()
                    ->where('schedule_id', $schedule->id)
                    ->first()
            ];
        });  

        $totalHomeStats = [];
        $totalAwayStats = [];

        if (in_array($schedule->competition, ['Basket Putra', 'Basket Putri'])) {
            $totalHomeStats = [
                'minute_play' => '-',
                'point'       => 0,
                'assist'      => 0,
                'rebound'     => 0,
                'steal'       => 0,
                'block'       => 0,
                'turnover'    => 0,
                'foul'        => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        } else if ($schedule->competition == 'Futsal Putra') {
            $totalHomeStats = [
                'point'       => 0,
                'yellow_card' => 0,
                'red_card'    => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        } else if ($schedule->competition == 'E-sport') {
            $totalHomeStats = [
                'kill_count'  => 0,
                'death_count' => 0,
                'assist'      => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        } else if ($schedule->competition == 'Voli Putra') {
            $totalHomeStats = [
                'point'       => 0,
                'service_ace' => 0,
                'block'       => 0,
            ];
            $totalAwayStats = $totalHomeStats;
        }

        foreach ($homePlayerStats as $homePlayerStat) {
            if (!$homePlayerStat) continue;
            foreach ($totalHomeStats as $statsName => $totalStats) {
                if ($statsName == 'minute_play') continue;
                $totalHomeStats[$statsName] += $homePlayerStat->$statsName ?? 0;
            }
        }

        foreach ($awayPlayerStats as $awayPlayerStat) {
            if (!$awayPlayerStat) continue;
            foreach ($totalAwayStats as $statsName => $totalStats) {
                if ($statsName == 'minute_play') continue;
                $totalAwayStats[$statsName] += $awayPlayerStat->$statsName ?? 0;
            }
        }  

        return view('cabang-lomba-detail', [
            'schedule' => $schedule,
            'rounds' => $rounds,
            'participants' => $participants,
            'homeTeamPlayers' => $homeTeamPlayers,
            'awayTeamPlayers' => $awayTeamPlayers,
            'homeTeamCrews' => $homeTeamCrews,
            'awayTeamCrews' => $awayTeamCrews,
            'homeTeamSummary' => $homeTeamSummary,
            'awayTeamSummary' => $awayTeamSummary,
            'homePlayerStats' => $homePlayerStats,
            'awayPlayerStats' => $awayPlayerStats,            
            'totalHomeStats' => $totalHomeStats,
            'totalAwayStats' => $totalAwayStats,
        ]);
    }

    public function updateStatus(Schedule $schedule)
    {
        if (!Auth::check() || Auth::user()->role != "Cabang Lomba") abort(404);

        if ($schedule->is_finished) {
            $schedule->is_finished = 0;
        } else {
            $schedule->is_finished = 1;
        }

        $schedule->save();
        return redirect()->back()->with('success', 'Status jadwal berhasil diubah');
    }

    public function updateScore(Schedule $schedule, Request $request)
    {
        if (!Auth::check() || Auth::user()->role != "Cabang Lomba") abort(404);

        for ($i = 1; $i <= $request->roundsCount; $i++) {
            if ($request->score_home[$i] == 0 && $request->score_away[$i] == 0) break;

            $round = Rounds::where('schedule_id', $schedule->id)
                ->where('round_no', $i)
                ->first();

            if ($round) {
                // UPDATE
                $round->update([
                    'home_score' => $request->score_home[$i],
                    'away_score' => $request->score_away[$i],
                ]);
            } else {
                // CREATE
                Rounds::create([
                    'schedule_id' => $schedule->id,
                    'round_no' => $i,
                    'home_score' => $request->score_home[$i],
                    'away_score' => $request->score_away[$i],
                ]);
            }
        }
        //update score olahraga
        if(in_array($schedule->competition, [
            'Basket Putra', 
            'Basket Putri', 
            'Voli Putra', 
            'E-sport',
            'Futsal Putra',
            'Badminton Tunggal Putra',
            'Badminton Ganda Putra',
            'Badminton Ganda Campuran'
        ])) {
            $homeParticipant = $schedule->teams
                ->where('pivot.home_away', 'Home')->first();

            $awayParticipant = $schedule->teams
                ->where('pivot.home_away', 'Away')->first();

            $schedule->teams()->updateExistingPivot(
                $homeParticipant->id, ['total_score' => $request->total_score_home]);

            $schedule->teams()->updateExistingPivot(
                $awayParticipant->id, ['total_score' => $request->total_score_away]);
        }
        //lomba seni
        if ($request->seniScore) {
            foreach ($request->seniScore as $teamId => $score) {
                $schedule->teams()->updateExistingPivot(
                    $teamId,
                    ['total_score' => (int) $score]
                );
            }
        }   

        return redirect()->back()->with('success', 'Score berhasil diupdate');
    }

    
}
