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
        Schema::create('team_crews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('name',255);
            $table->string('whatsapp', 20);
            $table->enum('role', ['Coach', 'Assistant Coach', 'Medic', 'Official']);
            $table->string('nrp',20)->nullable();
            $table->string('major',45)->nullable();
            $table->text('ktm_photo')->nullable();
            $table->enum('status', ['Menunggu', 'Ditolak', 'Diterima']);
            $table->text('revision')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_crews');
    }
};
