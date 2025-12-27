<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            // Ubah kolom menjadi nullable
            $table->string('jenis_ujian')->nullable()->change();
            $table->string('sekali_duduk')->nullable()->change();
        });

        DB::table('ujian_tahfidz')
            ->update([
                'jenis_ujian' => null,
                'sekali_duduk' => null,
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            // Kembalikan ke NOT NULL
            DB::table('ujian_tahfidz')
                ->whereNull('jenis_ujian')
                ->update(['jenis_ujian' => 'UTS']);

            DB::table('ujian_tahfidz')
                ->whereNull('sekali_duduk')
                ->update(['sekali_duduk' => 'tidak']);

            $table->string('jenis_ujian')->nullable(false)->change();
            $table->string('sekali_duduk')->nullable(false)->change();
        });
    }
};
