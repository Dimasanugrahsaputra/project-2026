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
        Schema::create('pengembalian_bukus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                ->constrained('peminjamen')
                ->cascadeOnDelete();

            $table->foreignId('petugas_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('kode_pengembalian')->unique();
            $table->date('tanggal_kembali');
            $table->integer('jumlah_hari_terlambat')->default(0);
            $table->decimal('total_denda', 10, 2)->default(0);
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->unique('peminjaman_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_bukus');
    }
};
