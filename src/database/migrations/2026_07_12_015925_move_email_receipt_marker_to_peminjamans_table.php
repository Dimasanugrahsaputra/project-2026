<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasColumn(
                'dendas',
                'bukti_pembayaran_dikirim_at'
            )
        ) {
            Schema::table('dendas', function (Blueprint $table): void {
                $table->dropColumn(
                    'bukti_pembayaran_dikirim_at'
                );
            });
        }

        if (
            ! Schema::hasColumn(
                'peminjamans',
                'bukti_peminjaman_dikirim_at'
            )
        ) {
            Schema::table(
                'peminjamans',
                function (Blueprint $table): void {
                    $table->timestamp(
                        'bukti_peminjaman_dikirim_at'
                    )
                        ->nullable()
                        ->after('status');
                }
            );
        }
    }

    public function down(): void
    {
        if (
            Schema::hasColumn(
                'peminjamans',
                'bukti_peminjaman_dikirim_at'
            )
        ) {
            Schema::table(
                'peminjamans',
                function (Blueprint $table): void {
                    $table->dropColumn(
                        'bukti_peminjaman_dikirim_at'
                    );
                }
            );
        }

        if (
            ! Schema::hasColumn(
                'dendas',
                'bukti_pembayaran_dikirim_at'
            )
        ) {
            Schema::table('dendas', function (Blueprint $table): void {
                $table->timestamp(
                    'bukti_pembayaran_dikirim_at'
                )
                    ->nullable()
                    ->after('tanggal_pembayaran');
            });
        }
    }
};