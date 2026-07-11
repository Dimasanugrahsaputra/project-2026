<?php

namespace App\Filament\Admin\Resources\PeminjamanResource\Pages;

use App\Filament\Admin\Resources\PeminjamanResource;
use App\Services\KirimBuktiPeminjaman;
use Filament\Resources\Pages\CreateRecord;

class CreatePeminjaman extends CreateRecord
{
    protected static string $resource =
        PeminjamanResource::class;

    protected function afterCreate(): void
    {
        app(KirimBuktiPeminjaman::class)
            ->kirim($this->record);
    }
}
