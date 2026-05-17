<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Participant;
use App\Models\Team;
use App\Models\StatisticTeam;
use App\Models\StatisticParticipant;
use App\Models\Rounds;
use Illuminate\Support\Facades\Auth;    

class StatisticController extends Controller
{
    public function updateSummary(Schedule $schedule, Request $request)
    {
        if (!Auth::check() || Auth::user()->role != "Cabang Lomba") abort(404);

        // HOME
        $summaryHome = StatisticTeam::where('schedule_id', $schedule->id)
            ->where('team_id', $request->homeTeamId)
            ->first();

        if ($summaryHome) {
            $summaryHome->update($request->summary_home);
        } else {
            // CREATE
            StatisticTeam::create(array_merge(
                [
                    'schedule_id' => $schedule->id,
                    'team_id' => $request->homeTeamId,
                    'competition' => $schedule->competition,
                ],
                $request->summary_home
            ));
        }
        // AWAY
        $summaryAway = StatisticTeam::where('schedule_id', $schedule->id)
            ->where('team_id', $request->awayTeamId)
            ->first();
        if ($summaryAway) {
            // UPDATE
            $summaryAway->update($request->summary_away);
        } else {
            // CREATE
            StatisticTeam::create(array_merge(
                [
                    'schedule_id' => $schedule->id,
                    'team_id' => $request->awayTeamId,
                    'competition' => $schedule->competition,
                ],
                $request->summary_away
            ));
        }

        return redirect()->back()->with('success', 'Summary berhasil diupdate');
    }

    private function convertMinuteToTime($value)
    {
        // kalau format mm:ss
        if (preg_match('/^\d{1,3}:\d{2}$/', $value)) {
            [$min, $sec] = explode(':', $value);
            return sprintf(
                '00:%02d:%02d',
                (int)$min,
                (int)$sec
            );
        }
        return '00:00:00';
    }

    public function updateStats(Schedule $schedule, Request $request)
    {
        if (!Auth::check() || Auth::user()->role != "Cabang Lomba") {
            abort(404);
        }

        // =====================
        // HOME STATS
        // =====================
        if ($request->home_stats) {
            foreach ($request->home_stats as $playerId => $stats) {
                // KONVERSI minute_play kalau ada
                if (isset($stats['minute_play'])) {
                    $stats['minute_play'] = $this->convertMinuteToTime($stats['minute_play']);
                }
                StatisticParticipant::updateOrCreate(
                    [
                        'schedule_id'    => $schedule->id,
                        'participant_id' => $playerId,
                        'competition'    => $schedule->competition,
                        'team_id'        => $request->homeTeamId,
                    ],
                    $stats
                );
            }
        }

        // =====================
        // AWAY STATS
        // =====================
        if ($request->away_stats) {
            foreach ($request->away_stats as $playerId => $stats) {
                // KONVERSI minute_play kalau ada
                if (isset($stats['minute_play'])) {
                    $stats['minute_play'] = $this->convertMinuteToTime($stats['minute_play']);
                }
                StatisticParticipant::updateOrCreate(
                    [
                        'schedule_id'     => $schedule->id,
                        'participant_id'  => $playerId,
                        'competition'    => $schedule->competition,
                        'team_id'         => $request->awayTeamId,
                    ],
                    $stats
                );
            }
        }

        return redirect()->back()->with('success', 'Stats berhasil diupdate');
    }

    public function showRecap(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != "Cabang Lomba") abort(404);

        $competition = $request->competition;
        $type = $request->type;
        $sort = request('sort', 'point');
        $direction = request('direction', 'desc');

        if (!$competition && !$type) return view('recap');        

        if ($type === "team") {
            if ($competition !== "Futsal Putra") {
                return back()->withErrors([
                    'noSummary' => "Tidak ada rekap per tim untuk cabang lomba $competition"
                ])->withInput();
            }

            $allTeams = Team::where('competition', $competition)->get();

            $teamsRecap = collect();

            foreach ($allTeams as $team) {
                $teamSummaries = StatisticTeam::where('team_id', $team->id)->get();
                $teamSummary = [
                    'team_id' => $team->id,
                    'team_name' => $team->name,
                    'point' => $team->schedules()->sum('schedule_team.total_score'),
                    'yellow_card' => 0,
                    'red_card' => 0,
                    'foul' => 0,
                ];
                foreach ($teamSummaries as $summary) {
                    $teamSummary['yellow_card'] += $summary->yellow_card ?? 0;
                    $teamSummary['red_card'] += $summary->red_card ?? 0;
                    $teamSummary['foul'] += $summary->foul ?? 0;
                }
                $teamsRecap->push($teamSummary);
            }

            $teamsRecap = $teamsRecap->sortBy(
                fn($team) => $team[$sort] ?? 0,
                SORT_REGULAR,
                $direction === 'desc'
            );

            if ($sort === 'team_name') {
                $teamsRecap = $teamsRecap->sortBy(
                    'team_name',
                    SORT_REGULAR,
                    $direction === 'desc'
                );
            }
            return view('recap', [
                'type' => 'team',
                'competition' => $competition,
                'teamsRecap' => $teamsRecap,
            ]);
        }
        else if ($type === "player") {
            $allPlayers = Participant::with('teams')
                ->whereHas('teams', function ($q) use ($competition) {
                    $q->where('competition', $competition);
                })->get();

            // TEMPLATE STAT
            if ($competition === "Futsal Putra") {
                $baseSummary = [
                    'player_name' => '',
                    'nrp'         => '',
                    'team_name'   => '',
                    'point'       => 0,
                    'yellow_card' => 0,
                    'red_card'    => 0,
                ];
            }
            else if ($competition === "Basket Putra" || $competition === "Basket Putri") {
                $baseSummary = [
                    'player_name' => '',
                    'nrp'         => '',
                    'team_name'   => '',
                    'point'       => 0,
                    'assist'      => 0,
                    'rebound'     => 0,
                    'steal'       => 0,
                ];
            }
            else if ($competition === "Voli Putra") {
                $baseSummary = [
                    'player_name' => '',
                    'nrp'         => '',
                    'team_name'   => '',
                    'point'       => 0,
                    'service_ace' => 0,
                    'block'       => 0,
                ];
            }
            else if ($competition === "E-sport") {
                $baseSummary = [
                    'player_name' => '',
                    'nrp'         => '',
                    'team_name'   => '',
                    'kill_count'  => 0,
                    'death_count' => 0,
                    'assist'      => 0,
                    'mvp_count'   => 0,
                ];
            }

            $allPlayersSummary = [];
            foreach ($allPlayers as $player) {
                $playerSummaries = StatisticParticipant::where('participant_id', $player->id)->where('competition', $competition)->get();                
                $playerSummary = $baseSummary;
                $playerSummary['player_name'] = $player->name;
                $playerSummary['nrp'] = $player->nrp;

                $teamId = $playerSummaries->first()?->team_id;
                $playerSummary['team_name'] = $player->teams()
                    ->where('competition', $competition)
                    ->first()?->name ?? '-';
                foreach ($playerSummaries as $summary) {
                    foreach ($playerSummary as $statsName => $value) {
                        if ($statsName !== 'mvp_count' && $statsName !== 'player_name'  && $statsName !== 'team_name') {
                            $playerSummary[$statsName] += $summary->$statsName ?? 0;
                        }
                    }
                }
                // MVP COUNT ESPORT
                if ($competition === 'E-sport') {
                    $playerSummary['mvp_count'] = StatisticTeam::where('mvp_id', $player->id)->count();
                }
                $allPlayersSummary[$player->id] = $playerSummary;
            }

            // SORT
            $sort = request('sort', 'point');
            $direction = request('direction', 'desc');

            $allPlayersSummary = collect($allPlayersSummary)->sortBy(
                fn($player) => $player[$sort] ?? 0,
                SORT_REGULAR,
                $direction === 'desc'
            );
            return view('recap', [
                'type' => 'player',
                'competition' => $competition,
                'allPlayersSummary' => $allPlayersSummary,
            ]);
        }      
    }
}
