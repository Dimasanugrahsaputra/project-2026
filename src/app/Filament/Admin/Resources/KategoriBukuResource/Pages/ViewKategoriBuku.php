<?php

namespace App\Filament\Admin\Resources\KategoriBukuResource\Pages;

use App\Filament\Admin\Resources\KategoriBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKategoriBuku extends ViewRecord
{
    protected static string $resource = KategoriBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit'),

            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }
}
