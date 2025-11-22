<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('matapelajaran', function (Blueprint $table) {

            // 1. Hapus FK lama
            $table->dropForeign(['id_pendidik']);

            // 2. Jadikan FK nullable
            $table->unsignedBigInteger('id_pendidik')->nullable()->change();

            // 3. Tambahkan FK baru dengan ON DELETE SET NULL
            $table->foreign('id_pendidik')
                ->references('id_pendidik')
                ->on('pendidik')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('matapelajaran', function (Blueprint $table) {
            $table->dropForeign(['id_pendidik']);

            $table->unsignedBigInteger('id_pendidik')->change();

            $table->foreign('id_pendidik')
                ->references('id_pendidik')
                ->on('pendidik')
                ->onDelete('restrict');
        });
    }
};
