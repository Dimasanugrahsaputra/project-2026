<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'kode_buku',
        'kategori_buku_id',
        'rak_buku_id',
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'stok',
        'deskripsi',
    ];

    public function kategoriBuku()
    {
        return $this->belongsTo(KategoriBuku::class, 'kategori_buku_id');
    }

    public function rakBuku()
    {
        return $this->belongsTo(RakBuku::class, 'rak_buku_id');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'buku_id');
    }
}
