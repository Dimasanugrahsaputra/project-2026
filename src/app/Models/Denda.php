<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'dendas';

    protected $fillable = [
        'pengembalian_buku_id',
        'jumlah_denda',
        'jumlah_dibayar',
        'status_pembayaran',
        'tanggal_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'jumlah_denda' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
    ];

    public function pengembalianBuku()
    {
        return $this->belongsTo(PengembalianBuku::class, 'pengembalian_buku_id');
    }
}
