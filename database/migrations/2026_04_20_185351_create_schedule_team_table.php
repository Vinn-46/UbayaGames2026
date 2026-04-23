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
        Schema::create('schedule_team', function (Blueprint $table) {
            // Primary Key: id INT NOT NULL
            $table->id(); 

            // Foreign Key untuk Schedules (INT NOT NULL)
            // Gunakan unsignedBigInteger jika tabel schedules menggunakan $table->id()
            $table->unsignedBigInteger('schedule_id');
            
            // Foreign Key untuk Teams (BIGINT UNSIGNED NOT NULL)
            $table->unsignedBigInteger('team_id');

            // Kolom Tambahan
            $table->enum('home_away', ['Home', 'Away'])->nullable(); // ENUM NULL
            $table->integer('total_score')->nullable(); // INT NULL

            // Indexes (Laravel otomatis membuat index untuk foreign keys, 
            // tapi kita definisikan manual agar sesuai permintaan SQL Anda)
            $table->index('team_id', 'fk_schedules_has_teams_teams1_idx');
            $table->index('schedule_id', 'fk_schedules_has_teams_schedules_idx');

            // Constraints
            $table->foreign('schedule_id', 'fk_schedules_has_teams_schedules')
                ->references('id')->on('schedules')
                ->onUpdate('no action')
                ->onDelete('no action');

            $table->foreign('team_id', 'fk_schedules_has_teams_teams1')
                ->references('id')->on('teams')
                ->onUpdate('no action')
                ->onDelete('no action');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_team');
    }
};
