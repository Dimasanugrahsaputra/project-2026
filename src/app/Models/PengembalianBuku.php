<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PengembalianBuku extends Model
{
    protected $table = 'pengembalian_bukus';

    protected $fillable = [
        'kode_pengembalian',
        'peminjaman_id',
        'tanggal_pengembalian',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function denda(): HasOne
    {
        return $this->hasOne(Denda::class, 'pengembalian_buku_id');
    }
}
