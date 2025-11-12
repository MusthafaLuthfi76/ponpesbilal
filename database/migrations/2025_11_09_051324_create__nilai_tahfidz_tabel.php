<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilaitahfidz', function (Blueprint $table) {
            $table->id('id_nilai_tahfidz'); // PK auto-increment

            // FK ke Santri (PK Santri adalah NIS, tipe string)
            $table->string('nis', 20); 
            $table->unsignedBigInteger('id_matapelajaran'); 
            $table->unsignedBigInteger('id_pendidik'); // Penguji
            $table->unsignedBigInteger('id_tahunAjaran')->nullable(); // Filter Semester

            // Metadata Ujian
            $table->enum('jenis_ujian', ['UTS', 'UAS']); 
            $table->boolean('sekali_duduk')->default(false); 

            // Data Agregasi (diisi setelah detail dihitung)
            $table->decimal('total_kesalahan_tajwid', 5, 2)->nullable(); 
            $table->decimal('total_kesalahan_itqan', 5, 2)->nullable();   
            $table->decimal('nilai_akhir_tahfidz', 5, 2)->nullable(); 
            
            $table->timestamps();
            
            // Definisi Foreign Keys
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            $table->foreign('id_matapelajaran')->references('id_matapelajaran')->on('matapelajaran')->onDelete('restrict');
            $table->foreign('id_pendidik')->references('id_pendidik')->on('pendidik')->onDelete('restrict');
            $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('restrict');

            // Unique Constraint (Opsional): Mencegah dua ujian Tahfidz yang sama di periode yang sama
            $table->unique(['nis', 'id_matapelajaran', 'id_tahunAjaran', 'jenis_ujian'], 'unique_tahfidz_ujian');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilaitahfidz');
    }
};