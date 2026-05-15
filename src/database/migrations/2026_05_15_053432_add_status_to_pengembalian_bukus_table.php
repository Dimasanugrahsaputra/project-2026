<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pengembalian_bukus', 'status')) {
            Schema::table('pengembalian_bukus', function (Blueprint $table) {
                $table->string('status')->default('tepat_waktu')->after('jumlah_hari_terlambat');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pengembalian_bukus', 'status')) {
            Schema::table('pengembalian_bukus', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
