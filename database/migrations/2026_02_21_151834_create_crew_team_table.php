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
        Schema::create('crew_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crew_id')
                  ->constrained('crews')
                  ->cascadeOnDelete();
            $table->foreignId('team_id')
                  ->constrained('teams')
                  ->cascadeOnDelete();
            $table->enum('role', ['Coach', 'Assistant Coach', 'Medic', 'Koorcab']);            
            $table->enum('status', ['Menunggu', 'Ditolak', 'Diterima']);
            $table->text('revision')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crew_team');
    }
};
