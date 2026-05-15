<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rak_bukus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rak');
            $table->string('kode_rak')->nullable()->unique();
            $table->string('lokasi_rak')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rak_bukus');
    }
};
