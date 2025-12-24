<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeKelasTypeInMatapelajaranTable extends Migration
{
    public function up(): void
    {
        Schema::table('matapelajaran', function (Blueprint $table) {
            $table->enum('kelas', ['1','2','3'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('matapelajaran', function (Blueprint $table) {
            $table->enum('kelas', ['7','8','9','10','11','12'])->change();
        });
    }
}
