<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantTeam extends Model
{
    protected $table = 'participant_team';
    public $timestamps = false;
    protected $fillable = [
        'participant_id',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
