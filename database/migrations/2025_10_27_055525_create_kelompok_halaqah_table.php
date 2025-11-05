<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_halaqah', function (Blueprint $table) {
            
            $table->id('id_halaqah');// Primary Key (PK)
            $table->string('nama_kelompok', 100);
            $table->unsignedBigInteger('id_pendidik'); 
            $table->timestamps(); 

            // Definisi Foreign Key Pendidik
            $table->foreign('id_pendidik')->references('id_pendidik')->on('pendidik')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_halaqah');
    }
};