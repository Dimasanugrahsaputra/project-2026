<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kategori_buku_id',
        'rak_buku_id',
        'kode_buku',
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'cover',
        'deskripsi',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'stok' => 'integer',
    ];

    public function kategoriBuku(): BelongsTo
    {
        return $this->belongsTo(
            KategoriBuku::class,
            'kategori_buku_id'
        );
    }

    public function rakBuku(): BelongsTo
    {
        return $this->belongsTo(
            RakBuku::class,
            'rak_buku_id'
        );
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'buku_id'
        );
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(
            Booking::class,
            'buku_id'
        );
    }

    public function getJudulAttribute(): ?string
    {
        return $this->judul_buku;
    }
}
