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
            $table->string('angkatan')->nullable();
            $table->string('status')->default('aktif');
            $table->unsignedBigInteger('id_tahunAjaran')->nullable();

            // Definisi Foreign Keys:
            $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('set null');
        
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('santri');
    }
};