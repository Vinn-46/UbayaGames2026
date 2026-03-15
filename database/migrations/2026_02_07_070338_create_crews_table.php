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
        Schema::create('crews', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('whatsapp', 20);
            $table->string('nrp',20)->nullable();
            $table->string('major',45)->nullable();
            $table->text('ktm_photo')->nullable();
            $table->enum('status', ['Menunggu', 'Ditolak', 'Diterima']);
            $table->text('revision')->nullable();
            $table->foreignId('house_id')
                  ->constrained('houses')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crews');
    }
};
