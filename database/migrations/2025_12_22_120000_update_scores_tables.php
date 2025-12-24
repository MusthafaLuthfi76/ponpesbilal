<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom keaktifan ke tabel nilai akademik
        Schema::table('nilaiakademik', function (Blueprint $table) {
            if (!Schema::hasColumn('nilaiakademik', 'nilai_keaktifan')) {
                $table->decimal('nilai_keaktifan', 5, 2)->nullable()->after('nilai_praktik');
            }
        });

        // Pastikan kolom juz nullable dan tambah constraint unik di ujian_tahfidz
        DB::statement('ALTER TABLE ujian_tahfidz MODIFY juz INT NULL');

        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->unique(
                ['nis', 'tahun_ajaran_id', 'jenis_ujian', 'sekali_duduk', 'id_penguji', 'juz'],
                'unique_ujian_tahfidz_per_juz'
            );
        });
    }

    public function down(): void
    {
        // Kembalikan constraint dan kolom
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->dropUnique('unique_ujian_tahfidz_per_juz');
        });

        DB::statement('ALTER TABLE ujian_tahfidz MODIFY juz INT NOT NULL');

        Schema::table('nilaiakademik', function (Blueprint $table) {
            if (Schema::hasColumn('nilaiakademik', 'nilai_keaktifan')) {
                $table->dropColumn('nilai_keaktifan');
            }
        });
    }
};
