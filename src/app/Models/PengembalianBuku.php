<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembalianBuku extends Model
{
    protected $table = 'pengembalian_bukus';

    protected $fillable = [
        'kode_pengembalian',
        'peminjaman_id',
        'petugas_id',
        'tanggal_kembali',
        'jumlah_hari_terlambat',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kembali' => 'date',
        'jumlah_hari_terlambat' => 'integer',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'pengembalian_buku_id');
    }
}
