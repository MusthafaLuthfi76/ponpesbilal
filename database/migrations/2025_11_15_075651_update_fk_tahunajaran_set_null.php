<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ===========================
        // MATA PELAJARAN
        // ===========================
        Schema::table('matapelajaran', function (Blueprint $table) {

            // HAPUS foreign key lama
            $table->dropForeign(['id_tahunAjaran']);

            // Jadikan nullable agar bisa SET NULL
            $table->unsignedBigInteger('id_tahunAjaran')->nullable()->change();

            // Tambahkan FK SET NULL
            $table->foreign('id_tahunAjaran')
                  ->references('id_tahunAjaran')
                  ->on('tahunajaran')
                  ->nullOnDelete();
        });

        // ===========================
        // SANTRI
        // ===========================
        Schema::table('santri', function (Blueprint $table) {

            $table->dropForeign(['id_tahunAjaran']);

            $table->unsignedBigInteger('id_tahunAjaran')->nullable()->change();

            $table->foreign('id_tahunAjaran')
                  ->references('id_tahunAjaran')
                  ->on('tahunajaran')
                  ->nullOnDelete();
        });

        // ===========================
        // NILAI AKADEMIK
        // ===========================
        Schema::table('nilaiakademik', function (Blueprint $table) {

            $table->dropForeign(['id_tahunAjaran']);

            $table->unsignedBigInteger('id_tahunAjaran')->nullable()->change();

            $table->foreign('id_tahunAjaran')
                  ->references('id_tahunAjaran')
                  ->on('tahunajaran')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        // ===========================
        // MATA PELAJARAN
        // ===========================
        Schema::table('matapelajaran', function (Blueprint $table) {
            $table->dropForeign(['id_tahunAjaran']);
            $table->unsignedBigInteger('id_tahunAjaran')->nullable(false)->change();
            $table->foreign('id_tahunAjaran')
                  ->references('id_tahunAjaran')
                  ->on('tahunajaran')
                  ->restrictOnDelete();
        });

        // ===========================
        // SANTRI
        // ===========================
        Schema::table('santri', function (Blueprint $table) {
            $table->dropForeign(['id_tahunAjaran']);
            $table->unsignedBigInteger('id_tahunAjaran')->nullable(false)->change();
            $table->foreign('id_tahunAjaran')
                  ->references('id_tahunAjaran')
                  ->on('tahunajaran')
                  ->restrictOnDelete();
        });

        // ===========================
        // NILAI AKADEMIK
        // ===========================
        Schema::table('nilaiakademik', function (Blueprint $table) {
            $table->dropForeign(['id_tahunAjaran']);
            $table->unsignedBigInteger('id_tahunAjaran')->nullable(false)->change();
            $table->foreign('id_tahunAjaran')
                  ->references('id_tahunAjaran')
                  ->on('tahunajaran')
                  ->restrictOnDelete();
        });
    }
};
