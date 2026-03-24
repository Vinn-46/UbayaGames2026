<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrewTeam extends Model
{
    protected $table = 'crew_team';
    public $timestamps = false;
    protected $fillable = [
        'team_id',
        'crew_id',
        'role',        
        'status',
        'revision'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }
}
