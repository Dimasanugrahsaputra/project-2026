<?php

namespace Database\Seeders;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@perpus.test'],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password'),
                'phone' => '081111111111',
                'address' => 'Tangerang',
                'role' => 'admin',
                'status' => 'aktif',
            ]
        );
        $admin->syncRoles(['admin']);

        $petugas = User::updateOrCreate(
            ['email' => 'petugas@perpus.test'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('password'),
                'phone' => '082222222222',
                'address' => 'Tangerang',
                'role' => 'petugas',
                'status' => 'aktif',
            ]
        );
        $petugas->syncRoles(['petugas']);

        $kepala = User::updateOrCreate(
            ['email' => 'kepala@perpus.test'],
            [
                'name' => 'Kepala Perpustakaan',
                'password' => Hash::make('password'),
                'phone' => '083333333333',
                'address' => 'Tangerang',
                'role' => 'kepala_perpustakaan',
                'status' => 'aktif',
            ]
        );
        $kepala->syncRoles(['kepala_perpustakaan']);

        $anggotaUser = User::updateOrCreate(
            ['email' => 'anggota@perpus.test'],
            [
                'name' => 'Anggota Perpustakaan',
                'password' => Hash::make('password'),
                'phone' => '084444444444',
                'address' => 'Tangerang',
                'role' => 'anggota',
                'status' => 'aktif',
            ]
        );
        $anggotaUser->syncRoles(['anggota']);

        Anggota::updateOrCreate(
            ['user_id' => $anggotaUser->id],
            [
                'kode_anggota' => 'AGT-0001',
                'tanggal_bergabung' => now()->toDateString(),
                'status' => 'aktif',
            ]
        );
    }
}
