<?php

namespace App\Filament\Admin\Resources\PeminjamanResource\Pages;

use App\Filament\Admin\Resources\PeminjamanResource;
use App\Models\Buku;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreatePeminjaman extends CreateRecord
{
    protected static string $resource = PeminjamanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['petugas_id'] = auth()->id();

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $details = $data['detailPeminjamans'] ?? [];

            unset($data['detailPeminjamans']);

            $peminjaman = static::getModel()::create($data);

            foreach ($details as $detail) {
                $buku = Buku::find($detail['buku_id']);

                if ($buku && $buku->stok >= $detail['jumlah']) {
                    $peminjaman->detailPeminjamans()->create([
                        'buku_id' => $detail['buku_id'],
                        'jumlah' => $detail['jumlah'],
                    ]);

                    $buku->decrement('stok', $detail['jumlah']);
                }
            }

            return $peminjaman;
        });
    }
}
