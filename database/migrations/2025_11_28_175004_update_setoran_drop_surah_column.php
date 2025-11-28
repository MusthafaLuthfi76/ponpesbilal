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
    Schema::table('setoran', function (Blueprint $table) {
        if (Schema::hasColumn('setoran', 'surah')) {
            $table->dropColumn('surah');
        }
    });
}

public function down(): void
{
    Schema::table('setoran', function (Blueprint $table) {
        $table->string('surah')->nullable();
    });
}
};
