<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilaikesantrian', function (Blueprint $table) {
            $table->id('id_nilai_kesantrian');
            
            $table->string('nis', 20); // FK ke Santri (PK Santri adalah NIS)
            $table->unsignedBigInteger('id_matapelajaran'); // FK ke MataPelajaran
            // FK ke Tahun Ajaran (Untuk filter 2022/2025 Ganjil di UI)
            $table->unsignedBigInteger('id_tahunAjaran'); 

            // ATRIBUT NILAI KESANTRIAN 
            $table->string('nilai_akhlak', 10)->nullable();
            $table->string('nilai_ibadah', 10)->nullable(); 
            $table->string('nilai_kerapian', 10)->nullable();
            $table->string('nilai_kedisiplinan', 10)->nullable();
            $table->string('nilai_ekstrakulikuler', 10)->nullable();
            $table->string('nilai_buku_pegangan', 10)->nullable();
            
            $table->timestamps();
            
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            $table->foreign('id_matapelajaran')->references('id_matapelajaran')->on('matapelajaran')->onDelete('restrict');
            // Definisi FK Tahun Ajaran
            $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('restrict');
            
            // Unique Constraint: Mencegah duplikasi input nilai kesantrian per mata pelajaran/periode
            $table->unique(['nis', 'id_matapelajaran', 'id_tahunAjaran'], 'unique_kesantrian_nilai_periode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilaikesantrian');
    }
};