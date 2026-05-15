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
        $kategori = KategoriBuku::where('nama_kategori', 'Teknologi')->first();
        $rak = RakBuku::where('nama_rak', 'Rak A')->first();

        if (! $kategori || ! $rak) {
            return;
        }

        Buku::updateOrCreate(
            ['kode_buku' => 'BK001'],
            [
                'kategori_buku_id' => $kategori->id,
                'rak_buku_id' => $rak->id,
                'judul_buku' => 'Belajar Laravel',
                'penulis' => 'Dimas',
                'penerbit' => 'Gramedia',
                'tahun_terbit' => 2024,
                'isbn' => '9786028519900',
                'stok' => 5,
                'deskripsi' => 'Buku pengenalan Laravel untuk membangun aplikasi web.',
            ]
        );
    }
}
