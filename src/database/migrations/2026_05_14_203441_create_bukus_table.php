<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();

            $table->string('kode_buku')->unique();
            $table->string('judul_buku');

            $table->foreignId('kategori_buku_id')
                ->constrained('kategori_bukus')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('rak_buku_id')
                ->constrained('rak_bukus')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('penulis');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->string('isbn')->nullable()->unique();
            $table->integer('stok')->default(0);
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};
