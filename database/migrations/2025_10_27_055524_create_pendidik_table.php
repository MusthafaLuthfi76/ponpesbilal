<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendidik', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pendidik')->primary(); // PK
            
            $table->string('nama', 100);
            $table->string('jabatan', 50);
            
            // FK untuk Otentikasi (ke tabel User)
            $table->unsignedBigInteger('id_user')->unique(); 
            
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendidik');
    }
};