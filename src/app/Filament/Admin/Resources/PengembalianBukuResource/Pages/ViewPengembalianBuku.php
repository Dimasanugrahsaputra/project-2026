<?php

namespace App\Filament\Admin\Resources\PengembalianBukuResource\Pages;

use App\Filament\Admin\Resources\PengembalianBukuResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPengembalianBuku extends ViewRecord
{
    protected static string $resource = PengembalianBukuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit'),
        ];
    }
}
