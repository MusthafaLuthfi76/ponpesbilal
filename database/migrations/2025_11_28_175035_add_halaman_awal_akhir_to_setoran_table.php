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
    Schema::table('setoran', function (Blueprint $table) {
        $table->integer('halaman_awal')->nullable()->after('juz');
        $table->integer('halaman_akhir')->nullable()->after('halaman_awal');
    });
}

public function down(): void
{
    Schema::table('setoran', function (Blueprint $table) {
        $table->dropColumn(['halaman_awal', 'halaman_akhir']);
    });
}
};