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
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengembalian_buku_id')
                ->constrained('pengembalian_bukus')
                ->cascadeOnDelete();

            $table->decimal('jumlah_denda', 10, 2)->default(0);
            $table->decimal('jumlah_dibayar', 10, 2)->default(0);

            $table->enum('status_pembayaran', [
                'belum_lunas',
                'lunas',
            ])->default('belum_lunas');

            $table->date('tanggal_pembayaran')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->unique('pengembalian_buku_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
