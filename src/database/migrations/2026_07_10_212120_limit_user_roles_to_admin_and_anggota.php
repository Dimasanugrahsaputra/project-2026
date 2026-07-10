<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Akun petugas lama diubah menjadi admin.
         * Periksa dahulu apakah semua akun petugas memang boleh
         * mendapat akses admin.
         */
        DB::table('users')
            ->where('role', 'petugas')
            ->update([
                'role' => 'admin',
            ]);

        DB::statement(
            "ALTER TABLE `users`
             MODIFY `role`
             ENUM('admin', 'anggota')
             NOT NULL DEFAULT 'anggota'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "ALTER TABLE `users`
             MODIFY `role`
             ENUM('admin', 'petugas', 'anggota')
             NOT NULL DEFAULT 'anggota'"
        );
    }
};
