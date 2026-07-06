<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('kode_booking')->unique();

            $table->foreignId('buku_id')
                ->constrained('bukus')
                ->restrictOnDelete();

            $table->string('nama_pemesan');
            $table->string('nomor_telepon', 30);
            $table->unsignedInteger('jumlah')->default(1);

            $table->date('tanggal_booking');
            $table->date('tanggal_kedaluwarsa')->nullable();

            $table->string('status')->default('menunggu');
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('tanggal_booking');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
