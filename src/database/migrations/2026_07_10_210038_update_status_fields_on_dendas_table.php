<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement(
            "ALTER TABLE `dendas`
             MODIFY `status` VARCHAR(30) NULL"
        );

        DB::statement(
            "ALTER TABLE `dendas`
             MODIFY `status_pembayaran` VARCHAR(30) NULL"
        );

        DB::table('dendas')
            ->where('status_pembayaran', 'lunas')
            ->update([
                'status_pembayaran' => 'sudah_lunas',
            ]);

        DB::table('dendas')
            ->whereNull('status')
            ->update([
                'status' => 'belum_dibayar',
            ]);

        DB::table('dendas')
            ->whereNull('status_pembayaran')
            ->update([
                'status_pembayaran' => 'belum_lunas',
            ]);

        DB::statement(
            "ALTER TABLE `dendas`
             MODIFY `status` VARCHAR(30)
             NOT NULL DEFAULT 'belum_dibayar'"
        );

        DB::statement(
            "ALTER TABLE `dendas`
             MODIFY `status_pembayaran` VARCHAR(30)
             NOT NULL DEFAULT 'belum_lunas'"
        );
    }

    public function down(): void
    {
        DB::table('dendas')
            ->where('status_pembayaran', 'sudah_lunas')
            ->update([
                'status_pembayaran' => 'lunas',
            ]);

        DB::table('dendas')
            ->where('status_pembayaran', 'jatuh_tempo')
            ->update([
                'status_pembayaran' => 'belum_lunas',
            ]);

        DB::statement(
            "ALTER TABLE `dendas`
             MODIFY `status` VARCHAR(30)
             NOT NULL DEFAULT 'belum_dibayar'"
        );

        DB::statement(
            "ALTER TABLE `dendas`
             MODIFY `status_pembayaran` VARCHAR(30)
             NOT NULL DEFAULT 'belum_lunas'"
        );
    }
};
