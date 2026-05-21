<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'dendas';

    protected $fillable = [
        'pengembalian_buku_id',
        'jumlah_denda',
        'status_pembayaran',
        'tanggal_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'jumlah_denda' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
    ];

    public function pengembalianBuku(): BelongsTo
    {
        return $this->belongsTo(PengembalianBuku::class, 'pengembalian_buku_id');
    }
}
