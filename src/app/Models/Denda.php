<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denda extends Model
{
    protected $table = 'dendas';

    protected $fillable = [
        'kode_denda',
        'pengembalian_buku_id',
        'jumlah_denda',
        'jumlah_dibayar',
        'status',
        'status_pembayaran',
        'tanggal_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'jumlah_denda' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (Denda $denda): void {
            $jumlahDenda = (float) ($denda->jumlah_denda ?? 0);
            $jumlahDibayar = (float) ($denda->jumlah_dibayar ?? 0);

            if ($jumlahDibayar > 0) {
                $denda->status = 'sudah_dibayar';
            } else {
                $denda->status = 'belum_dibayar';
            }

            if ($jumlahDenda > 0 && $jumlahDibayar >= $jumlahDenda) {
                $denda->status_pembayaran = 'lunas';
            } else {
                $denda->status_pembayaran = 'belum_lunas';
            }

            if ($jumlahDibayar > 0 && empty($denda->tanggal_pembayaran)) {
                $denda->tanggal_pembayaran = now();
            }

            if ($jumlahDibayar <= 0) {
                $denda->tanggal_pembayaran = null;
            }
        });
    }

    public function pengembalianBuku(): BelongsTo
    {
        return $this->belongsTo(PengembalianBuku::class, 'pengembalian_buku_id');
    }
}
