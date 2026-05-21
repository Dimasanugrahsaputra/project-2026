<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian_bukus', function (Blueprint $table) {
            $table->id();

            $table->string('kode_pengembalian')->unique();

            $table->foreignId('peminjaman_id')
                ->constrained('peminjamans')
                ->cascadeOnDelete()
                ->unique();

            $table->date('tanggal_pengembalian');

            $table->enum('status', [
                'tepat_waktu',
                'terlambat',
            ])->default('tepat_waktu');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian_bukus');
    }
};
