<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matapelajaran', function (Blueprint $table) {

            // Tambah kolom kelas
            $table->enum('kelas', ['7','8','9','10','11','12'])
                  ->after('nama_matapelajaran');

            // Tambah kolom materi pelajaran (long text)
            $table->longText('materi_pelajaran')
                  ->nullable()
                  ->after('kelas');
        });
    }

    public function down(): void
    {
        Schema::table('matapelajaran', function (Blueprint $table) {
            $table->dropColumn('kelas');
            $table->dropColumn('materi_pelajaran');
        });
    }
};
