<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilaiakademik', function (Blueprint $table) {

            // 1. Drop foreign key lama (kalau ada)
            // MySQL akan mengabaikan kalau sudah tidak ada
            try {
                $table->dropForeign('nilaikademik_id_matapelajaran_foreign');
            } catch (\Exception $e) {}

            // 2. Tambahkan foreign key baru dengan CASCADE
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

            // Kembalikan ke restrict jika rollback
            try {
                $table->dropForeign('nilaikademik_id_matapelajaran_foreign');
            } catch (\Exception $e) {}

            $table->foreign('id_matapelajaran')
                  ->references('id_matapelajaran')
                  ->on('matapelajaran')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
        });
    }
};
