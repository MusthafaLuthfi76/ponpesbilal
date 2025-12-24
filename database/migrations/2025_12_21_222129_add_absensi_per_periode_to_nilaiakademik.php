<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nilaiakademik', function (Blueprint $table) {
            // Tambah kolom baru untuk UTS dan UAS
            $table->integer('izin_uts')->default(0)->after('jumlah_ghaib');
            $table->integer('sakit_uts')->default(0)->after('izin_uts');
            $table->integer('ghaib_uts')->default(0)->after('sakit_uts');

            $table->integer('izin_uas')->default(0)->after('ghaib_uts');
            $table->integer('sakit_uas')->default(0)->after('izin_uas');
            $table->integer('ghaib_uas')->default(0)->after('sakit_uas');
        });

        // Migrasi data lama ke format baru
        // Asumsi: data lama akan dibagi rata ke UTS dan UAS
        DB::statement("
            UPDATE nilaiakademik
            SET
                izin_uts = CEIL(COALESCE(jumlah_izin, 0) / 2.0),
                sakit_uts = CEIL(COALESCE(jumlah_sakit, 0) / 2.0),
                ghaib_uts = CEIL(COALESCE(jumlah_ghaib, 0) / 2.0),
                izin_uas = COALESCE(jumlah_izin, 0) - CEIL(COALESCE(jumlah_izin, 0) / 2.0),
                sakit_uas = COALESCE(jumlah_sakit, 0) - CEIL(COALESCE(jumlah_sakit, 0) / 2.0),
                ghaib_uas = COALESCE(jumlah_ghaib, 0) - CEIL(COALESCE(jumlah_ghaib, 0) / 2.0)
            WHERE 1
        ");

        // Hapus kolom lama setelah data dimigrasi
        Schema::table('nilaiakademik', function (Blueprint $table) {
            $table->dropColumn(['jumlah_izin', 'jumlah_sakit', 'jumlah_ghaib']);
        });
    }

    public function down()
    {
        Schema::table('nilaiakademik', function (Blueprint $table) {
            // Tambah kembali kolom lama
            $table->integer('jumlah_izin')->default(0)->after('nilai_praktik');
            $table->integer('jumlah_sakit')->default(0)->after('jumlah_izin');
            $table->integer('jumlah_ghaib')->default(0)->after('jumlah_sakit');
        });

        // Migrasi data kembali ke format lama
        DB::statement("
            UPDATE nilaiakademik
            SET
                jumlah_izin = COALESCE(izin_uts, 0) + COALESCE(izin_uas, 0),
                jumlah_sakit = COALESCE(sakit_uts, 0) + COALESCE(sakit_uas, 0),
                jumlah_ghaib = COALESCE(ghaib_uts, 0) + COALESCE(ghaib_uas, 0)
            WHERE 1
        ");

        // Hapus kolom baru
        Schema::table('nilaiakademik', function (Blueprint $table) {
            $table->dropColumn([
                'izin_uts', 'sakit_uts', 'ghaib_uts',
                'izin_uas', 'sakit_uas', 'ghaib_uas'
            ]);
        });
    }
};
