<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table): void {
            if (Schema::hasColumn('peminjamans', 'petugas_id')) {
                $table->dropConstrainedForeignId('petugas_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table): void {
            $table->foreignId('petugas_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }
};
