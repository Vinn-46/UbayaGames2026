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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('nrp',9);
            $table->string('major',45);
            $table->string('ktm_photo');
            $table->string('whatsapp',20);
            $table->enum('status', ['Menunggu', 'Ditolak', 'Diterima']);
            $table->string('revision')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
