<?php

namespace App\Filament\Admin\Resources\KategoriBukuResource\Pages;

use App\Filament\Admin\Resources\KategoriBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriBuku extends EditRecord
{
    protected static string $resource = KategoriBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
