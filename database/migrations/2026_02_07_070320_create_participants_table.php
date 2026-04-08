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
            $table->foreignId('house_id')
                  ->constrained('houses')
                  ->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('nrp',9)->unique();;
            $table->string('major',45);
            $table->date('birthdate');
            $table->text('ktm_photo');
            $table->string('whatsapp',20);
            $table->string('mobilelegend', 20)->nullable();
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
