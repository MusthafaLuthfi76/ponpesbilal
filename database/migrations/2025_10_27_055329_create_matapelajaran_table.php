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
        Schema::create('matapelajaran', function (Blueprint $table) {
            
            // Primary Key (PK) dan Identitas
            // Menggunakan unsignedBigInteger agar konsisten dengan FK yang dibuat Laravel default
            $table->unsignedBigInteger('id_matapelajaran')->primary(); 
            $table->string('nama_matapelajaran', 100);
            
            // Kolom Nilai Bobot dan KKM
            $table->decimal('kkm', 5, 2); 
            $table->decimal('bobot_UTS', 5, 2); 
            $table->decimal('bobot_UAS', 5, 2); 
            $table->decimal('bobot_praktik', 5, 2);

            // Foreign Keys (FK)
            $table->unsignedBigInteger('id_pendidik'); // FK ke Pendidik
            $table->unsignedBigInteger('id_tahunAjaran'); // FK ke TahunAjaran

            $table->timestamps(); // Menambahkan created_at dan updated_at

            // Definisi Foreign Keys
            // Relasi ke Pendidik: restrict (tidak boleh hapus Pendidik jika masih mengajar)
            $table->foreign('id_pendidik')->references('id_pendidik')->on('pendidik')->onDelete('restrict');
            
            // Relasi ke TahunAjaran: restrict
            $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matapelajaran');
    }
};