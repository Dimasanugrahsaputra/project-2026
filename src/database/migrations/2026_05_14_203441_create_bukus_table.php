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
        Schema::create('bukus', function (Blueprint $table) {
    $table->id();
    $table->foreignId('kategori_buku_id')->constrained('kategori_bukus')->cascadeOnDelete();
    $table->foreignId('rak_buku_id')->constrained('rak_bukus')->cascadeOnDelete();

    $table->string('kode_buku')->unique();
    $table->string('judul_buku');
    $table->string('penulis');
    $table->string('penerbit')->nullable();
    $table->year('tahun_terbit')->nullable();
    $table->string('isbn')->nullable();
    $table->integer('stok')->default(0);
    $table->text('deskripsi')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
