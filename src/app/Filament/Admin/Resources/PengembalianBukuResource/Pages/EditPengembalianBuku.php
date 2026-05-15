<?php

namespace App\Filament\Admin\Resources\PengembalianBukuResource\Pages;

use App\Filament\Admin\Resources\PengembalianBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengembalianBuku extends EditRecord
{
    protected static string $resource = PengembalianBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
