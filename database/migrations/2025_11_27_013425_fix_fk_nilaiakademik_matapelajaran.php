<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilaiakademik', function (Blueprint $table) {
            // Drop FK kalau ada
            try {
                $table->dropForeign(['id_matapelajaran']);
            } catch (\Throwable $e) {}

            // Tambah FK baru
            $table->foreign('id_matapelajaran')
                  ->references('id_matapelajaran')
                  ->on('matapelajaran')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('nilaiakademik', function (Blueprint $table) {
            try {
                $table->dropForeign(['id_matapelajaran']);
            } catch (\Throwable $e) {}

            $table->foreign('id_matapelajaran')
                  ->references('id_matapelajaran')
                  ->on('matapelajaran')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
        });
    }
};
