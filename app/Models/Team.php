<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\House;

class Team extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'competition',
        'house_id',
        'status',
        'revision'
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function participantTeams()
    {
        return $this->hasMany(ParticipantTeam::class);
    }

    public function crewTeams()
    {
        return $this->hasMany(CrewTeam::class);
    }
    public function participants()
    {
        return $this->belongsToMany(
            Participant::class,
            'participant_team',
            'team_id',
            'participant_id'
        );
    }
}
