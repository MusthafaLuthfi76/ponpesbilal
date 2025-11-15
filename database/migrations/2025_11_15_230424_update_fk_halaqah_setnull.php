<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            // hapus FK lama
            $table->dropForeign(['id_halaqah']);

            // tambah FK baru dengan SET NULL
            $table->foreign('id_halaqah')
                ->references('id_halaqah')->on('kelompok_halaqah')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('santri', function (Blueprint $table) {
            $table->dropForeign(['id_halaqah']);

            // kembalikan ke restrict jika rollback
            $table->foreign('id_halaqah')
                ->references('id_halaqah')->on('kelompok_halaqah')
                ->onDelete('restrict');
        });
    }
};
