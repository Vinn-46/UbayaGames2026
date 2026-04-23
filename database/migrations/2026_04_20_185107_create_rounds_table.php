<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('rounds', function (Blueprint $table) {
        $table->id(); // Primary Key
        
        // Menghubungkan ke tabel schedules (Foreign Key)
        // Pastikan nama tabel di database adalah 'schedules'
        $table->foreignId('schedule_id')
              ->constrained('schedules')
              ->onUpdate('no action')
              ->onDelete('no action');

        $table->integer('round_no'); // INT NOT NULL
        $table->integer('home_score'); // INT NOT NULL
        $table->integer('away_score'); // INT NOT NULL
        
        $table->timestamps(); // Opsional: created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rounds');
    }
};
