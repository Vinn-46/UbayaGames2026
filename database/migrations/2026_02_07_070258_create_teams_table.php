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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name',45);
            $table->enum('competition', ['Basket', 'Futsal', 'Voli', 'Badminton', 'E-sport', 'Poster', 'Lukis', 'Dance', 'Fotografi']);
            $table->foreignId('house_id')
                  ->constrained('houses')
                  ->cascadeOnDelete();
            $table->enum('status', ['Menunggu', 'Ditolak', 'Diterima']);
            $table->text('revision')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
