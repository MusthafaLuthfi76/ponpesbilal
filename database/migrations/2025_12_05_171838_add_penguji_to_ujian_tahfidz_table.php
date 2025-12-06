<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->unsignedBigInteger('id_penguji')->nullable()->after('nis');
            $table->foreign('id_penguji')
                ->references('id_pendidik')
                ->on('pendidik')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->dropForeign(['id_penguji']);
            $table->dropColumn('id_penguji');
        });
    }
};
