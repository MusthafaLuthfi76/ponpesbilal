<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilaiakademik', function (Blueprint $table) {
            $table->id('id_nilai_akademik'); // PK auto-increment

            $table->string('nis', 20); // FK ke Santri (PK Santri adalah NIS)
            $table->unsignedBigInteger('id_matapelajaran'); 
            // Tambahkan FK id_tahunAjaran agar nilai terikat periode (Wajib, meskipun di RAT sebelumnya tidak ada)
            $table->unsignedBigInteger('id_tahunAjaran')->nullable();
            
            // KOLOM NILAI UTAMA 
            $table->decimal('nilai_UTS', 5, 2)->nullable();
            $table->decimal('nilai_UAS', 5, 2)->nullable();
            $table->decimal('nilai_praktik', 5, 2)->nullable();

            // KOLOM ABSENSI 
            $table->integer('jumlah_izin')->nullable(); // Kolom JUMLAH IZIN
            $table->integer('jumlah_sakit')->nullable(); // Kolom JUMLAH SAKIT
            $table->integer('jumlah_ghaib')->nullable(); // Kolom JUMLAH GHAIB

            // KOLOM HASIL (Otomatis/Display)
            $table->decimal('nilai_rata_rata', 5, 2)->nullable(); // Kolom NILAI RATA-RATA
            $table->string('predikat', 5)->nullable(); // Kolom PREDIKAT (Contoh: 'A', 'B')
            $table->string('keterangan', 50)->nullable(); // Kolom KETERANGAN (Contoh: 'LULUS')

            $table->timestamps();
            
            // --- DEFINISI FOREIGN KEYS ---
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            $table->foreign('id_matapelajaran')->references('id_matapelajaran')->on('matapelajaran')->onDelete('restrict');
            $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('restrict');
            
            // Unique Constraint: Mencegah duplikasi input nilai akademik per mata pelajaran/semester
            $table->unique(['nis', 'id_matapelajaran', 'id_tahunAjaran'], 'unique_akademik_nilai_periode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilaiakademik');
    }
};