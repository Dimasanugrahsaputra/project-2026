<?php

namespace App\Filament\Admin\Resources\PeminjamanResource\Pages;

use App\Filament\Admin\Resources\PeminjamanResource;
use App\Models\Buku;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeminjaman extends EditRecord
{
    protected static string $resource = PeminjamanResource::class;

    protected array $oldDetails = [];

    protected function beforeSave(): void
    {
        $this->oldDetails = $this->record
            ->detailPeminjaman()
            ->get(['buku_id', 'jumlah'])
            ->map(fn ($detail) => [
                'buku_id' => $detail->buku_id,
                'jumlah' => $detail->jumlah,
            ])
            ->toArray();
    }

    protected function afterSave(): void
    {
        foreach ($this->oldDetails as $detail) {
            Buku::where('id', $detail['buku_id'])
                ->increment('stok', $detail['jumlah']);
        }

        $this->record->load('detailPeminjaman');

        foreach ($this->record->detailPeminjaman as $detail) {
            Buku::where('id', $detail->buku_id)
                ->decrement('stok', $detail->jumlah);
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus'),
        ];
    }
}
