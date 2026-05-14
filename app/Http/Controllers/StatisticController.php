<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
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
}
