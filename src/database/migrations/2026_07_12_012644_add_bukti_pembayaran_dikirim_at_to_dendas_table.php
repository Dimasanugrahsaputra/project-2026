<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dendas', function (Blueprint $table): void {
            $table->timestamp('bukti_pembayaran_dikirim_at')
                ->nullable()
                ->after('tanggal_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('dendas', function (Blueprint $table): void {
            $table->dropColumn(
                'bukti_pembayaran_dikirim_at'
            );
        });
    }
};