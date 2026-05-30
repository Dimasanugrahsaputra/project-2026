<?php

namespace App\Filament\Admin\Resources\PengembalianBukuResource\Pages;

use App\Filament\Admin\Resources\PengembalianBukuResource;
use App\Models\Buku;
use App\Models\Peminjaman;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreatePengembalianBuku extends CreateRecord
{
    protected static string $resource = PengembalianBukuResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $peminjaman = Peminjaman::query()->find($data['peminjaman_id'] ?? null);

        if (empty($data['kode_pengembalian'])) {
            $data['kode_pengembalian'] = 'KMB-' . now()->format('YmdHis');
        }

        if (empty($data['tanggal_pengembalian'])) {
            $data['tanggal_pengembalian'] = now()->toDateString();
        }

        if ($peminjaman) {
            $tanggalPengembalian = Carbon::parse($data['tanggal_pengembalian'])->startOfDay();
            $tanggalJatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo)->startOfDay();

            $data['status'] = $tanggalPengembalian->gt($tanggalJatuhTempo)
                ? 'terlambat'
                : 'tepat_waktu';
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data): Model {
            $peminjaman = Peminjaman::query()
                ->with(['detailPeminjaman'])
                ->lockForUpdate()
                ->find($data['peminjaman_id'] ?? null);

            if (! $peminjaman) {
                throw ValidationException::withMessages([
                    'peminjaman_id' => 'Data peminjaman tidak ditemukan.',
                ]);
            }

            if ($peminjaman->pengembalianBuku()->exists()) {
                throw ValidationException::withMessages([
                    'peminjaman_id' => 'Peminjaman ini sudah pernah dikembalikan.',
                ]);
            }

            if ($peminjaman->status === 'dikembalikan') {
                throw ValidationException::withMessages([
                    'peminjaman_id' => 'Status peminjaman ini sudah dikembalikan.',
                ]);
            }

            if ($peminjaman->detailPeminjaman->isEmpty()) {
                throw ValidationException::withMessages([
                    'peminjaman_id' => 'Peminjaman ini belum memiliki detail buku.',
                ]);
            }

            $record = static::getModel()::query()->create($data);

            foreach ($peminjaman->detailPeminjaman as $detail) {
                Buku::query()
                    ->whereKey($detail->buku_id)
                    ->increment('stok', (int) $detail->jumlah);
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
            ]);

            return $record;
        });
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Pengembalian berhasil dibuat')
            ->body('Status peminjaman otomatis berubah menjadi dikembalikan dan stok buku bertambah.')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
