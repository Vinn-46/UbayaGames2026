<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticTeam extends Model
{
    protected $table = 'statistic_team';

    protected $fillable = [
        'team_id',
        'schedule_id',
        'competition',

        // Basket
        'two_point_success',
        'two_point_failed',

        'three_point_success',
        'three_point_failed',

        'free_throw_success',
        'free_throw_failed',

        'rebound_offensive',
        'rebound_defensive',

        'assist',
        'steal',
        'block',
        'turnover',

        'foul',

        'points_off_turnover',

        // Futsal
        'yellow_card',
        'red_card',

        // Esport
        'mvp_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function mvp()
    {
        return $this->belongsTo(Participant::class, 'mvp_id');
    }
}