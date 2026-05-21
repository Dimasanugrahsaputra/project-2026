<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            if (! Schema::hasColumn('anggotas', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('anggotas', 'nama_lengkap')) {
                $table->string('nama_lengkap')->nullable();
            }

            if (! Schema::hasColumn('anggotas', 'email')) {
                $table->string('email')->nullable();
            }

            if (! Schema::hasColumn('anggotas', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }

            if (! Schema::hasColumn('anggotas', 'alamat')) {
                $table->text('alamat')->nullable();
            }

            if (! Schema::hasColumn('anggotas', 'tanggal_bergabung')) {
                $table->date('tanggal_bergabung')->nullable();
            }

            if (! Schema::hasColumn('anggotas', 'status')) {
                $table->string('status')->default('aktif');
            }
        });
    }

    public function down(): void
    {
        //
    }
};
