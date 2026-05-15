<?php

namespace App\Filament\Admin\Resources\KategoriBukuResource\Pages;

use App\Filament\Admin\Resources\KategoriBukuResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriBuku extends CreateRecord
{
    protected static string $resource = KategoriBukuResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['kode_kategori'])) {
            $data['kode_kategori'] = 'KTG-' . now()->format('YmdHis');
        }

        return $data;
    }
}
