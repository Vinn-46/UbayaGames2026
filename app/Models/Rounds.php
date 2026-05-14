<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rounds extends Model
{
    protected $fillable = [
        'schedule_id',
        'round_no',
        'home_score',
        'away_score',
    ];
    
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
