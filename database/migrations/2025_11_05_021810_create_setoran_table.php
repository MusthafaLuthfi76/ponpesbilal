<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setoran', function (Blueprint $table) {
            $table->id('id_setoran');
            $table->string('nis');
            $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            $table->date('tanggal_setoran');
            $table->string('juz')->nullable();
            $table->string('surah');
            $table->string('ayat');
            $table->enum('status', ['Lancar', 'Kurang Lancar', 'Tidak Lancar'])->default('Lancar');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setoran');
    }
};