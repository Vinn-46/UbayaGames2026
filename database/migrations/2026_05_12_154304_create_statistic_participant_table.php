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
        Schema::create('statistic_participant', function (Blueprint $table) {

            $table->id();

            $table->foreignId('participant_id')
                ->constrained('participants')
                ->onDelete('cascade');

            $table->foreignId('team_id')
                ->constrained('teams')
                ->onDelete('cascade');

            $table->foreignId('schedule_id')
                ->constrained('schedules')
                ->onDelete('cascade');

            $table->enum('competition', [
                'Basket Putra',
                'Basket Putri',
                'Futsal Putra',
                'Voli Putra',
                'Badminton Ganda Putra',
                'Badminton Tunggal Putra',
                'Badminton Ganda Campuran',
                'E-sport',
                'Poster',
                'Lukis',
                'Dance',
                'Fotografi'
            ]);

            // BASKET
            $table->time('minute_play')->nullable();

            $table->integer('point')->nullable();
            $table->integer('rebound')->nullable();
            $table->integer('steal')->nullable();
            $table->integer('block')->nullable();
            $table->integer('turnover')->nullable();
            $table->integer('foul')->nullable();

            // VOLI
            $table->integer('service_ace')->nullable();

            // ESPORT
            $table->integer('kill_count')->nullable();
            $table->integer('death_count')->nullable();

            // FUTSAL
            $table->integer('yellow_card')->nullable();
            $table->integer('red_card')->nullable();

            // Basket & Esport
            $table->integer('assist')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_participant');
    }
};