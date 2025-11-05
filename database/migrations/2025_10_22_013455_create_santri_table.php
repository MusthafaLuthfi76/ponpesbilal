<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('santri', function (Blueprint $table) {
            
            $table->string('nis', 20)->primary(); 
            $table->string('nama', 100);
            $table->string('angkatan', 10)->nullable();            
            $table->enum('status', ['MA', 'MTS', 'Alumni', 'Keluar'])->default('MTS'); 
            $table->unsignedBigInteger('id_tahunAjaran')->nullable();
            $table->unsignedBigInteger('id_halaqah');
                        
            $table->timestamps();

            // Definisi Foreign Keys 
            $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('set null');

            $table->foreign('id_halaqah')->references('id_halaqah')->on('kelompok_halaqah')->onDelete('restrict');
        
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};