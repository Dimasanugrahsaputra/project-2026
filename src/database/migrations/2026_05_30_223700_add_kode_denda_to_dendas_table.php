<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            if (! Schema::hasColumn('dendas', 'kode_denda')) {
                $table->string('kode_denda')->nullable()->after('id');
            }

            if (! Schema::hasColumn('dendas', 'status')) {
                $table->string('status')->default('belum_dibayar')->after('jumlah_denda');
            }
        });
    }

    public function down(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            if (Schema::hasColumn('dendas', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('dendas', 'kode_denda')) {
                $table->dropColumn('kode_denda');
            }
        });
    }
};
