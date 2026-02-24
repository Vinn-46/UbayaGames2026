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
}
