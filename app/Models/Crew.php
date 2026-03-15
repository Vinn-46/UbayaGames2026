<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'whatsapp',
        'nrp',
        'major',
        'ktm_photo',
        'status',
        'revision',
        'house_id'
    ];

    public function crewTeams()
    {
        return $this->hasMany(CrewTeam::class);
    }
}
