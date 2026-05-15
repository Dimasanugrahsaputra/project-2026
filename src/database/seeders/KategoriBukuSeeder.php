<?php

namespace Database\Seeders;

use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;

class KategoriBukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategoriBukus = [
            [
                'kode_kategori' => 'KTG001',
                'nama_kategori' => 'Teknologi',
                'deskripsi' => 'Kategori buku tentang teknologi dan komputer.',
            ],
            [
                'kode_kategori' => 'KTG002',
                'nama_kategori' => 'Pendidikan',
                'deskripsi' => 'Kategori buku tentang pendidikan dan pembelajaran.',
            ],
            [
                'kode_kategori' => 'KTG003',
                'nama_kategori' => 'Sejarah',
                'deskripsi' => 'Kategori buku tentang sejarah.',
            ],
            [
                'kode_kategori' => 'KTG004',
                'nama_kategori' => 'Novel',
                'deskripsi' => 'Kategori buku fiksi dan novel.',
            ],
            [
                'kode_kategori' => 'KTG005',
                'nama_kategori' => 'Agama',
                'deskripsi' => 'Kategori buku agama dan spiritual.',
            ],
        ];

        foreach ($kategoriBukus as $kategori) {
            KategoriBuku::updateOrCreate(
                [
                    'kode_kategori' => $kategori['kode_kategori'],
                ],
                [
                    'nama_kategori' => $kategori['nama_kategori'],
                    'deskripsi' => $kategori['deskripsi'],
                ]
            );
        }
    }
}
