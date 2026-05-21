<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,

            KategoriBukuSeeder::class,
            RakBukuSeeder::class,
            BukuSeeder::class,

            AnggotaSeeder::class,
            PeminjamanSeeder::class,
            DetailPeminjamanSeeder::class,
            PengembalianBukuSeeder::class,
            DendaSeeder::class,
        ]);
    }
}
