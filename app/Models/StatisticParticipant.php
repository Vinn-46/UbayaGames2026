<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticParticipant extends Model
{
    protected $table = 'statistic_participant';

    protected $fillable = [
        'participant_id',
        'team_id',
        'schedule_id',
        'competition',

        // Basket
        'minute_play',
        'point',
        'rebound',
        'steal',
        'block',
        'turnover',
        'foul',

        // Voli
        'service_ace',

        // Esport
        'kill_count',
        'death_count',

        // Futsal
        'yellow_card',
        'red_card',

        // Basket & Esport
        'assist',
    ];

    protected $casts = [
        'minute_play' => 'datetime:H:i:s',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}