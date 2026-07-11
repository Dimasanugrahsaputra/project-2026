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
        'tanggal_pembayaran',
        'bukti_pembayaran_dikirim_at',
        'status',
        'status_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'jumlah_denda' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
        'bukti_pembayaran_dikirim_at' => 'datetime',
    ];

    public function pengembalianBuku(): BelongsTo
    {
        return $this->belongsTo(
            PengembalianBuku::class,
            'pengembalian_buku_id'
        );
    }
}