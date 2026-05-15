<?php

namespace Database\Seeders;

use App\Models\RakBuku;
use Illuminate\Database\Seeder;

class RakBukuSeeder extends Seeder
{
    public function run(): void
    {
        RakBuku::updateOrCreate(
            ['kode_rak' => 'RAK-A'],
            [
                'nama_rak' => 'Rak A',
                'lokasi_rak' => 'Lantai 1',
            ]
        );

        RakBuku::updateOrCreate(
            ['kode_rak' => 'RAK-B'],
            [
                'nama_rak' => 'Rak B',
                'lokasi_rak' => 'Lantai 1',
            ]
        );
    }
}
