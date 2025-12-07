<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('nilaikesantrian', function (Blueprint $table) {
        $table->dropForeign(['id_matapelajaran']);
        $table->foreign('id_matapelajaran')
            ->references('id_matapelajaran')
            ->on('matapelajaran')
            ->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('nilaikesantrian', function (Blueprint $table) {
        $table->dropForeign(['id_matapelajaran']);
        $table->foreign('id_matapelajaran')
            ->references('id_matapelajaran')
            ->on('matapelajaran')
            ->onDelete('restrict');
    });
}
};
