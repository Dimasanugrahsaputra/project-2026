<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->date('tanggal_pengajuan')
                ->nullable()
                ->after('kode_peminjaman');

            $table->date('tanggal_rencana_pengambilan')
                ->nullable()
                ->after('tanggal_pengajuan');

            $table->date('tanggal_kembali')
                ->nullable()
                ->after('tanggal_jatuh_tempo');

            $table->text('catatan_anggota')
                ->nullable()
                ->after('catatan');

            $table->text('catatan_admin')
                ->nullable()
                ->after('catatan_anggota');
        });

        DB::statement(
            'ALTER TABLE `peminjamans`
             MODIFY `tanggal_pinjam` DATE NULL'
        );

        DB::statement(
            'ALTER TABLE `peminjamans`
             MODIFY `tanggal_jatuh_tempo` DATE NULL'
        );

        DB::statement(
            "ALTER TABLE `peminjamans`
             MODIFY `status`
             ENUM(
                'diajukan',
                'disetujui',
                'ditolak',
                'dibatalkan',
                'dipinjam',
                'dikembalikan',
                'terlambat'
             )
             NOT NULL DEFAULT 'diajukan'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "UPDATE `peminjamans`
             SET `status` = 'dipinjam'
             WHERE `status` NOT IN (
                'dipinjam',
                'dikembalikan',
                'terlambat'
             )"
        );

        DB::statement(
            "UPDATE `peminjamans`
             SET `tanggal_pinjam` = CURRENT_DATE
             WHERE `tanggal_pinjam` IS NULL"
        );

        DB::statement(
            "UPDATE `peminjamans`
             SET `tanggal_jatuh_tempo` = CURRENT_DATE
             WHERE `tanggal_jatuh_tempo` IS NULL"
        );

        DB::statement(
            "ALTER TABLE `peminjamans`
             MODIFY `status`
             ENUM(
                'dipinjam',
                'dikembalikan',
                'terlambat'
             )
             NOT NULL DEFAULT 'dipinjam'"
        );

        DB::statement(
            'ALTER TABLE `peminjamans`
             MODIFY `tanggal_pinjam` DATE NOT NULL'
        );

        DB::statement(
            'ALTER TABLE `peminjamans`
             MODIFY `tanggal_jatuh_tempo` DATE NOT NULL'
        );

        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_pengajuan',
                'tanggal_rencana_pengambilan',
                'tanggal_kembali',
                'catatan_anggota',
                'catatan_admin',
            ]);
        });
    }
};
