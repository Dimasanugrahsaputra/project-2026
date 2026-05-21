<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminAccessSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Kategori Buku
            'view_any_kategori_buku',
            'view_kategori_buku',
            'create_kategori_buku',
            'update_kategori_buku',
            'delete_kategori_buku',
            'delete_any_kategori_buku',

            // Rak Buku
            'view_any_rak_buku',
            'view_rak_buku',
            'create_rak_buku',
            'update_rak_buku',
            'delete_rak_buku',
            'delete_any_rak_buku',

            // Buku
            'view_any_buku',
            'view_buku',
            'create_buku',
            'update_buku',
            'delete_buku',
            'delete_any_buku',

            // Anggota
            'view_any_anggota',
            'view_anggota',
            'create_anggota',
            'update_anggota',
            'delete_anggota',
            'delete_any_anggota',

            // Peminjaman
            'view_any_peminjaman',
            'view_peminjaman',
            'create_peminjaman',
            'update_peminjaman',
            'delete_peminjaman',
            'delete_any_peminjaman',

            // Detail Peminjaman
            'view_any_detail_peminjaman',
            'view_detail_peminjaman',
            'create_detail_peminjaman',
            'update_detail_peminjaman',
            'delete_detail_peminjaman',
            'delete_any_detail_peminjaman',

            // Pengembalian Buku
            'view_any_pengembalian_buku',
            'view_pengembalian_buku',
            'create_pengembalian_buku',
            'update_pengembalian_buku',
            'delete_pengembalian_buku',
            'delete_any_pengembalian_buku',

            // Denda
            'view_any_denda',
            'view_denda',
            'create_denda',
            'update_denda',
            'delete_denda',
            'delete_any_denda',

            // User
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $role = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($permissions);

        $admin = User::firstOrCreate(
            [
                'email' => 'admin@perpus.test',
            ],
            [
                'name' => 'Admin Perpustakaan',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole($role);

        // Kalau sudah ada user lain, user pertama juga dikasih akses admin
        $firstUser = User::query()->first();

        if ($firstUser) {
            $firstUser->assignRole($role);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
