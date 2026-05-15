<?php

namespace App\Filament\Admin\Resources\PengembalianBukuResource\Pages;

use App\Filament\Admin\Resources\PengembalianBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengembalianBukus extends ListRecords
{
    protected static string $resource = PengembalianBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
