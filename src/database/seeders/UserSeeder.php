<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@perpus.test',
            ],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password'),
            ]
        );

        $admin->syncRoles(['admin']);

        $petugas = User::updateOrCreate(
            [
                'email' => 'petugas@perpus.test',
            ],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('password'),
            ]
        );

        $petugas->syncRoles(['petugas']);
    }
}
