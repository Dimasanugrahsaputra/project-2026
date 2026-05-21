<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pengembalian_bukus')) {
            return;
        }

        Schema::table('pengembalian_bukus', function (Blueprint $table) {
            if (! Schema::hasColumn('pengembalian_bukus', 'petugas_id')) {
                $table->foreignId('petugas_id')
                    ->nullable()
                    ->after('peminjaman_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('pengembalian_bukus', 'jumlah_hari_terlambat')) {
                $table->integer('jumlah_hari_terlambat')
                    ->default(0)
                    ->after('tanggal_pengembalian');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('pengembalian_bukus')) {
            return;
        }

        Schema::table('pengembalian_bukus', function (Blueprint $table) {
            if (Schema::hasColumn('pengembalian_bukus', 'petugas_id')) {
                $table->dropForeign(['petugas_id']);
                $table->dropColumn('petugas_id');
            }

            if (Schema::hasColumn('pengembalian_bukus', 'jumlah_hari_terlambat')) {
                $table->dropColumn('jumlah_hari_terlambat');
            }
        });
    }
};
