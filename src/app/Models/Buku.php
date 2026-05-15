<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kode_buku',
        'judul_buku',
        'kategori_buku_id',
        'rak_buku_id',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'deskripsi',
    ];

    public function kategoriBuku(): BelongsTo
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_buku_id');
    }

    public function rakBuku(): BelongsTo
    {
        return $this->belongsTo(RakBuku::class, 'rak_buku_id');
    }
}
