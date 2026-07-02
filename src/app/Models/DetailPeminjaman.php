<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamans';

    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jumlah',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (DetailPeminjaman $detail): void {
            $buku = Buku::query()->find($detail->buku_id);

            if (! $buku) {
                throw ValidationException::withMessages([
                    'buku_id' => 'Data buku tidak ditemukan.',
                ]);
            }

            if ((int) $detail->jumlah <= 0) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Jumlah buku harus lebih dari 0.',
                ]);
            }

            if ((int) $buku->stok < (int) $detail->jumlah) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Stok buku tidak mencukupi. Stok tersedia: ' . $buku->stok,
                ]);
            }

            $buku->decrement('stok', (int) $detail->jumlah);
        });

        static::updating(function (DetailPeminjaman $detail): void {
            $jumlahBaru = (int) $detail->jumlah;
            $jumlahLama = (int) $detail->getOriginal('jumlah');

            $bukuBaruId = (int) $detail->buku_id;
            $bukuLamaId = (int) $detail->getOriginal('buku_id');

            if ($jumlahBaru <= 0) {
                throw ValidationException::withMessages([
                    'jumlah' => 'Jumlah buku harus lebih dari 0.',
                ]);
            }

            if ($bukuBaruId === $bukuLamaId) {
                $selisih = $jumlahBaru - $jumlahLama;

                if ($selisih > 0) {
                    $buku = Buku::query()->find($bukuBaruId);

                    if (! $buku || (int) $buku->stok < $selisih) {
                        throw ValidationException::withMessages([
                            'jumlah' => 'Stok buku tidak mencukupi untuk perubahan jumlah.',
                        ]);
                    }

                    $buku->decrement('stok', $selisih);
                }

                if ($selisih < 0) {
                    Buku::query()
                        ->whereKey($bukuBaruId)
                        ->increment('stok', abs($selisih));
                }

                return;
            }

            Buku::query()
                ->whereKey($bukuLamaId)
                ->increment('stok', $jumlahLama);

            $bukuBaru = Buku::query()->find($bukuBaruId);

            if (! $bukuBaru || (int) $bukuBaru->stok < $jumlahBaru) {
                Buku::query()
                    ->whereKey($bukuLamaId)
                    ->decrement('stok', $jumlahLama);

                throw ValidationException::withMessages([
                    'buku_id' => 'Stok buku baru tidak mencukupi.',
                ]);
            }

            $bukuBaru->decrement('stok', $jumlahBaru);
        });

        static::deleting(function (DetailPeminjaman $detail): void {
            Buku::query()
                ->whereKey($detail->buku_id)
                ->increment('stok', (int) $detail->jumlah);
        });
    }

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
