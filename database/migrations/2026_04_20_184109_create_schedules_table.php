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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id(); // Secara default INT NOT NULL AUTO_INCREMENT PRIMARY KEY
            
            // Kolom ENUM untuk tipe kegiatan
            $table->enum('type', ['Pertandingan', 'Perlombaan']);
            
            // Kolom ENUM untuk babak/fase
            $table->enum('phase', [
                'Group Phase', 
                'Round of 16', 
                'Quarter Final', 
                'Semifinal', 
                'Third Place Playoff', 
                'Final'
            ]);

            $table->string('name', 45)->nullable(); // VARCHAR(45) NULL
            $table->string('venue', 45); // VARCHAR(45) NOT NULL
            $table->dateTime('time'); // DATETIME NOT NULL
            
            // Kolom ENUM untuk jenis kompetisi
            $table->enum('competition', [
                'Basket Putra', 'Basket Putri', 'Futsal Putra', 'Voli Putra', 
                'Badminton Ganda Putra', 'Badminton Tunggal Putra', 
                'Badminton Ganda Campuran', 'E-sport', 'Poster', 
                'Lukis', 'Dance', 'Fotografi'
            ]);

            $table->boolean('is_finished')->default(false); // TINYINT(1) NOT NULL
            
            $table->timestamps(); // Menambahkan created_at dan updated_at (Opsional tapi disarankan)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};