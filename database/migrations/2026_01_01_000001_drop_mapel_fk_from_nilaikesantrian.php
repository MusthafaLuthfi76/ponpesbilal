<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilaikesantrian', function (Blueprint $table) {
            // Lepas FKs yang memakai index lama
            if (Schema::hasColumn('nilaikesantrian', 'nis')) {
                $table->dropForeign(['nis']);
            }
            if (Schema::hasColumn('nilaikesantrian', 'id_tahunAjaran')) {
                $table->dropForeign(['id_tahunAjaran']);
            }
            if (Schema::hasColumn('nilaikesantrian', 'id_matapelajaran')) {
                $table->dropForeign(['id_matapelajaran']);
            }

            if (Schema::hasColumn('nilaikesantrian', 'nis')) {
                $table->dropUnique('unique_kesantrian_nilai_periode');
            }

            if (Schema::hasColumn('nilaikesantrian', 'id_matapelajaran')) {
                $table->dropColumn('id_matapelajaran');
            }

            if (Schema::hasColumn('nilaikesantrian', 'nis')) {
                $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
            }
            if (Schema::hasColumn('nilaikesantrian', 'id_tahunAjaran')) {
                $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('restrict');
            }

            if (Schema::hasColumn('nilaikesantrian', 'nis')) {
                $table->unique(['nis', 'id_tahunAjaran'], 'unique_kesantrian_per_tahun');
            }
        });
    }

    public function down(): void
    {
        Schema::table('nilaikesantrian', function (Blueprint $table) {
            if (Schema::hasColumn('nilaikesantrian', 'nis')) {
                $table->dropUnique('unique_kesantrian_per_tahun');
                $table->dropForeign(['nis']);
            }
            if (Schema::hasColumn('nilaikesantrian', 'id_tahunAjaran')) {
                $table->dropForeign(['id_tahunAjaran']);
            }

            if (!Schema::hasColumn('nilaikesantrian', 'id_matapelajaran')) {
                $table->unsignedBigInteger('id_matapelajaran')->nullable()->after('nis');
            }
        });

        Schema::table('nilaikesantrian', function (Blueprint $table) {
            if (Schema::hasColumn('nilaikesantrian', 'id_matapelajaran')) {
                $table->foreign('id_matapelajaran')
                    ->references('id_matapelajaran')
                    ->on('matapelajaran')
                    ->onDelete('restrict');

                if (Schema::hasColumn('nilaikesantrian', 'nis')) {
                    $table->foreign('nis')->references('nis')->on('santri')->onDelete('cascade');
                }

                if (Schema::hasColumn('nilaikesantrian', 'id_tahunAjaran')) {
                    $table->foreign('id_tahunAjaran')->references('id_tahunAjaran')->on('tahunajaran')->onDelete('restrict');
                }

                if (Schema::hasColumn('nilaikesantrian', 'nis') && Schema::hasColumn('nilaikesantrian', 'id_tahunAjaran')) {
                    $table->unique(['nis', 'id_matapelajaran', 'id_tahunAjaran'], 'unique_kesantrian_nilai_periode');
                }
            }
        });
    }
};
