<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'type',
        'phase',
        'name',
        'venue',
        'time',
        'competition',
        'is_finished',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'schedule_team', 'schedule_id', 'team_id')
                    ->withPivot('id', 'home_away', 'total_score') // Mengambil kolom tambahan di tabel pivot
                    ->withTimestamps(); // Tambahkan ini jika migration pivot Anda pakai $table->timestamps()
    }
}
