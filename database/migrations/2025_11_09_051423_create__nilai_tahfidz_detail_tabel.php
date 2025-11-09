<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilaitahfidz_detail', function (Blueprint $table) {
            $table->id(); // PK auto-increment

            // FK ke Tabel Induk NilaiTahfidz
            $table->unsignedBigInteger('id_nilai_tahfidz'); 

            // Kolom Detail Per Baris Ujian (sesuai UI)
            $table->integer('juz_ke'); 
            $table->integer('kesalahan_tajwid'); 
            $table->integer('kesalahan_itqan'); 
            $table->integer('total_kesalahan_per_juz'); 

            $table->timestamps();
            
            // Definisi Foreign Key
            $table->foreign('id_nilai_tahfidz')
                  ->references('id_nilai_tahfidz')
                  ->on('nilaitahfidz')
                  ->onDelete('cascade'); // Jika ujian utama dihapus, detail juga ikut terhapus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilaitahfidz_detail');
    }
};