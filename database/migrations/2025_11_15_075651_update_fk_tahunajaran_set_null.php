<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // MATA PELAJARAN
    Schema::table('matapelajaran', function (Blueprint $table) {
        // Drop FK lama
        $table->dropForeign(['id_tahunAjaran']);

        // Tambah FK baru
        $table->foreign('id_tahunAjaran')
              ->references('id_tahunAjaran')
              ->on('tahunajaran')
              ->nullOnDelete(); // SET NULL
    });

    // SANTRI
    Schema::table('santri', function (Blueprint $table) {
        $table->dropForeign(['id_tahunAjaran']);

        $table->foreign('id_tahunAjaran')
              ->references('id_tahunAjaran')
              ->on('tahunajaran')
              ->nullOnDelete();
    });

    // NILAI AKADEMIK
    Schema::table('nilaiakademik', function (Blueprint $table) {
        $table->dropForeign(['id_tahunAjaran']);

        $table->foreign('id_tahunAjaran')
              ->references('id_tahunAjaran')
              ->on('tahunajaran')
              ->nullOnDelete();
    });
}

public function down()
{
    // Kembalikan ke RESTRICT kalau rollback
    Schema::table('matapelajaran', function (Blueprint $table) {
        $table->dropForeign(['id_tahunAjaran']);
        $table->foreign('id_tahunAjaran')
              ->references('id_tahunAjaran')
              ->on('tahunajaran')
              ->restrictOnDelete();
    });

    Schema::table('santri', function (Blueprint $table) {
        $table->dropForeign(['id_tahunAjaran']);
        $table->foreign('id_tahunAjaran')
              ->references('id_tahunAjaran')
              ->on('tahunajaran')
              ->restrictOnDelete();
    });

    Schema::table('nilaiakademik', function (Blueprint $table) {
        $table->dropForeign(['id_tahunAjaran']);
        $table->foreign('id_tahunAjaran')
              ->references('id_tahunAjaran')
              ->on('tahunajaran')
              ->restrictOnDelete();
    });
}

};
