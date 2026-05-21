<?php

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Peminjaman::class, 'peminjaman_id')->constrained('peminjamans')->cascadeOnDelete();
            $table->foreignIdFor(Buku::class, 'buku_id')->constrained('bukus')->cascadeOnDelete();
            $table->integer('jumlah')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamans');
    }
};      
