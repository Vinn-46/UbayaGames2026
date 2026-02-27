<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'nrp',
        'major',
        'ktm_photo',
        'whatsapp',
        'mobilelegend',
    ];

    protected $guarded = ['status', 'revision',];


}
