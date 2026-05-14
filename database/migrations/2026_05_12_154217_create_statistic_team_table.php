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
        Schema::create('statistic_team', function (Blueprint $table) {

            $table->id();

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
            $table->integer('two_point_success')->nullable();
            $table->integer('two_point_failed')->nullable();

            $table->integer('three_point_success')->nullable();
            $table->integer('three_point_failed')->nullable();

            $table->integer('free_throw_success')->nullable();
            $table->integer('free_throw_failed')->nullable();

            $table->integer('rebound_offensive')->nullable();
            $table->integer('rebound_defensive')->nullable();

            $table->integer('assist')->nullable();
            $table->integer('steal')->nullable();
            $table->integer('block')->nullable();
            $table->integer('turnover')->nullable();

            $table->integer('foul')->nullable();

            $table->integer('points_off_turnover')->nullable();

            // FUTSAL
            $table->integer('yellow_card')->nullable();
            $table->integer('red_card')->nullable();

            // ESPORT
            $table->foreignId('mvp_id')
                ->nullable()
                ->constrained('participants')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistic_team');
    }
};