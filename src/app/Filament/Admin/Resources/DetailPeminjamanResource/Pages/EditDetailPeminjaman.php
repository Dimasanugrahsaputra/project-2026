<?php

namespace App\Filament\Admin\Resources\DetailPeminjamanResource\Pages;

use App\Filament\Admin\Resources\DetailPeminjamanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDetailPeminjaman extends EditRecord
{
    protected static string $resource = DetailPeminjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
