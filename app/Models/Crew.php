<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'whatsapp',
        'birthdate',
        'nrp',
        'major',
        'ktm_photo',
        'house_id'
    ];

    public function crewTeams()
    {
        return $this->hasMany(CrewTeam::class);
    }
    public function teams()
    {
        return $this->belongsToMany(
            Team::class,
            'crew_team',            
            'crew_id',
            'team_id',
        )->withPivot('role', 'status', 'revision');
    }
}
