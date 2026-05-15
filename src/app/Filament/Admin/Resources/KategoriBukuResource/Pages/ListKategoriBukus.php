<?php

namespace App\Filament\Admin\Resources\KategoriBukuResource\Pages;

use App\Filament\Admin\Resources\KategoriBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriBukus extends ListRecords
{
    protected static string $resource = KategoriBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
