<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('rak_bukus')) {
            return;
        }

        if (! Schema::hasColumn('rak_bukus', 'kode_rak')) {
            Schema::table('rak_bukus', function (Blueprint $table) {
                if (Schema::hasColumn('rak_bukus', 'nama_rak')) {
                    $table->string('kode_rak')->nullable()->after('nama_rak');
                } else {
                    $table->string('kode_rak')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('rak_bukus') && Schema::hasColumn('rak_bukus', 'kode_rak')) {
            Schema::table('rak_bukus', function (Blueprint $table) {
                $table->dropColumn('kode_rak');
            });
        }
    }
};
