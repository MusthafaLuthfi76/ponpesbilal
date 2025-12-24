<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * =========================
         * 1️⃣ DROP kolom lama
         * =========================
         */
        Schema::table('nilaikesantrian', function (Blueprint $table) {
            $columnsToDrop = [
                'nilai_akhlak',
                'nilai_ibadah',
                'nilai_kerapian',
                'nilai_kedisiplinan',
                'nilai_ekstrakulikuler',
                'nilai_buku_pegangan',
            ];

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('nilaikesantrian', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        /**
         * =========================
         * 2️⃣ ADD kolom UTS & UAS
         * =========================
         */
        Schema::table('nilaikesantrian', function (Blueprint $table) {
            // ===== UTS =====
            $table->string('akhlak_uts', 2)->nullable();
            $table->string('ibadah_uts', 2)->nullable();
            $table->string('kerapian_uts', 2)->nullable();
            $table->string('kedisiplinan_uts', 2)->nullable();
            $table->string('ekstrakulikuler_uts', 2)->nullable();
            $table->string('buku_pegangan_uts', 2)->nullable();

            // ===== UAS =====
            $table->string('akhlak_uas', 2)->nullable();
            $table->string('ibadah_uas', 2)->nullable();
            $table->string('kerapian_uas', 2)->nullable();
            $table->string('kedisiplinan_uas', 2)->nullable();
            $table->string('ekstrakulikuler_uas', 2)->nullable();
            $table->string('buku_pegangan_uas', 2)->nullable();
        });
    }

    public function down(): void
    {
        /**
         * =========================
         * 1️⃣ DROP kolom baru
         * =========================
         */
        Schema::table('nilaikesantrian', function (Blueprint $table) {
            $newColumns = [
                'akhlak_uts',
                'ibadah_uts',
                'kerapian_uts',
                'kedisiplinan_uts',
                'ekstrakulikuler_uts',
                'buku_pegangan_uts',
                'akhlak_uas',
                'ibadah_uas',
                'kerapian_uas',
                'kedisiplinan_uas',
                'ekstrakulikuler_uas',
                'buku_pegangan_uas',
            ];

            foreach ($newColumns as $column) {
                if (Schema::hasColumn('nilaikesantrian', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        /**
         * =========================
         * 2️⃣ Kembalikan kolom lama
         * =========================
         */
        Schema::table('nilaikesantrian', function (Blueprint $table) {
            $table->decimal('nilai_akhlak', 5, 2)->nullable();
            $table->decimal('nilai_ibadah', 5, 2)->nullable();
            $table->decimal('nilai_kerapian', 5, 2)->nullable();
            $table->decimal('nilai_kedisiplinan', 5, 2)->nullable();
            $table->decimal('nilai_ekstrakulikuler', 5, 2)->nullable();
            $table->decimal('nilai_buku_pegangan', 5, 2)->nullable();
        });
    }
};
