<?php

namespace App\Filament\Admin\Resources\PengembalianBukuResource\Pages;

use App\Filament\Admin\Resources\PengembalianBukuResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePengembalianBuku extends CreateRecord
{
    protected static string $resource = PengembalianBukuResource::class;

    protected function afterCreate(): void
    {
        $peminjaman = $this->record->peminjaman;

        if (! $peminjaman) {
            return;
        }

        $peminjaman->detailPeminjaman()
            ->with('buku')
            ->get()
            ->each(function ($detail) {
                if ($detail->buku) {
                    $detail->buku->increment('stok', $detail->jumlah);
                }
            });

        $peminjaman->update([
            'status' => 'dikembalikan',
        ]);
    }
}
