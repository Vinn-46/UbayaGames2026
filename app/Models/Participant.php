<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'house_id',
        'name',
        'nrp',
        'major',
        'ktm_photo',
        'whatsapp',
        'mobilelegend',
        'status',
        'revision'
    ];

    public function index()
    {
        $participants = Participant::all();
        return view('participants.index', compact('participants'));
    }

    public function participantTeams()
    {
        return $this->hasMany(ParticipantTeam::class);
    }

    public function teams()
    {
        return $this->belongsToMany(
            Team::class,
            'participant_team',   // nama pivot table
            'participant_id',     // foreign key di pivot
            'team_id'             // related key di pivot
        )->withPivot('back_number');
    }
}
