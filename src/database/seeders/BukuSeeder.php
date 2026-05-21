<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\RakBuku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriTeknologi = KategoriBuku::firstOrCreate(
            ['nama_kategori' => 'Teknologi'],
            [
                'kode_kategori' => 'KTG-001',
                'deskripsi' => 'Kategori buku teknologi dan pemrograman',
            ]
        );

        $kategoriPendidikan = KategoriBuku::firstOrCreate(
            ['nama_kategori' => 'Pendidikan'],
            [
                'kode_kategori' => 'KTG-002',
                'deskripsi' => 'Kategori buku pendidikan',
            ]
        );

        $rakA = RakBuku::firstOrCreate(
            ['kode_rak' => 'RAK-A'],
            [
                'nama_rak' => 'Rak A',
                'lokasi_rak' => 'Lantai 1',
            ]
        );

        $rakB = RakBuku::firstOrCreate(
            ['kode_rak' => 'RAK-B'],
            [
                'nama_rak' => 'Rak B',
                'lokasi_rak' => 'Lantai 1',
            ]
        );

        $bukus = [
            [
                'kode_buku' => 'BK001',
                'judul_buku' => 'Belajar Laravel',
                'kategori_buku_id' => $kategoriTeknologi->id,
                'rak_buku_id' => $rakA->id,
                'penulis' => 'Dimas',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2024,
                'stok' => 5,
            ],
            [
                'kode_buku' => 'BK002',
                'judul_buku' => 'Dasar Pemrograman Web',
                'kategori_buku_id' => $kategoriTeknologi->id,
                'rak_buku_id' => $rakA->id,
                'penulis' => 'Budi Santoso',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2023,
                'stok' => 7,
            ],
            [
                'kode_buku' => 'BK003',
                'judul_buku' => 'Database MariaDB',
                'kategori_buku_id' => $kategoriTeknologi->id,
                'rak_buku_id' => $rakB->id,
                'penulis' => 'Andi Wijaya',
                'penerbit' => 'Elex Media',
                'tahun_terbit' => 2022,
                'stok' => 4,
            ],
            [
                'kode_buku' => 'BK004',
                'judul_buku' => 'Algoritma dan Struktur Data',
                'kategori_buku_id' => $kategoriPendidikan->id,
                'rak_buku_id' => $rakB->id,
                'penulis' => 'Siti Aminah',
                'penerbit' => 'Deepublish',
                'tahun_terbit' => 2021,
                'stok' => 6,
            ],
            [
                'kode_buku' => 'BK005',
                'judul_buku' => 'Pemrograman PHP Modern',
                'kategori_buku_id' => $kategoriTeknologi->id,
                'rak_buku_id' => $rakA->id,
                'penulis' => 'Rudi Hartono',
                'penerbit' => 'Andi Publisher',
                'tahun_terbit' => 2024,
                'stok' => 8,
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::updateOrCreate(
                ['kode_buku' => $buku['kode_buku']],
                $buku
            );
        }
    }
}
