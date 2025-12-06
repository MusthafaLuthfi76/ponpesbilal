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
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->integer('juz')->nullable()->change();
            $table->integer('tajwid')->nullable()->change();
            $table->integer('itqan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujian_tahfidz', function (Blueprint $table) {
            $table->integer('juz')->nullable(false)->change();
            $table->integer('tajwid')->nullable(false)->change();
            $table->integer('itqan')->nullable(false)->change();
        });
    }
};
