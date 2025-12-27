<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->boolean('is_header')->default(false)->after('id_penguji');
        });
    }

    public function down()
    {
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->dropColumn('is_header');
        });
    }
};
