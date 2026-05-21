<?php

namespace App\Filament\Admin\Resources\DendaResource\Pages;

use App\Filament\Admin\Resources\DendaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDenda extends ViewRecord
{
    protected static string $resource = DendaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit'),
        ];
    }
}
