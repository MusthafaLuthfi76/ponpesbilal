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
        Schema::create('ujian_tahfidz', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            $table->integer('juz');
            $table->integer('tajwid')->default(0);
            $table->integer('itqan')->default(0);
            $table->integer('total_kesalahan')->default(0);
            $table->enum('jenis_ujian', ['UTS', 'UAS'])->default('UTS');
            $table->enum('sekali_duduk', ['ya', 'tidak'])->default('tidak'); // ✅ kolom baru
            $table->unsignedBigInteger('tahun_ajaran_id')->nullable();
            $table->foreign('tahun_ajaran_id')
                ->references('id_tahunAjaran')
                ->on('tahunajaran')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujian_tahfidz');
    }
};
