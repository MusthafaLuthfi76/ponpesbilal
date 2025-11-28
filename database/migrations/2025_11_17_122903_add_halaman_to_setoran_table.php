<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('setoran', function (Blueprint $table) {
            if (!Schema::hasColumn('setoran', 'halaman_awal')) {
                $table->integer('halaman_awal')->nullable()->after('juz');
            }

            if (!Schema::hasColumn('setoran', 'halaman_akhir')) {
                $table->integer('halaman_akhir')->nullable()->after('halaman_awal');
            }

            if (Schema::hasColumn('setoran', 'halaman')) {
                $table->dropColumn('halaman');
            }
        });
    }

    public function down()
    {
        Schema::table('setoran', function (Blueprint $table) {
            if (!Schema::hasColumn('setoran', 'halaman')) {
                $table->string('halaman')->nullable();
            }

            $table->dropColumn('halaman_awal');
            $table->dropColumn('halaman_akhir');
        });
    }
};
