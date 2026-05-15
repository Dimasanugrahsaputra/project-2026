<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';

    protected $fillable = [
    'kode_peminjaman',
    'anggota_id',
    'petugas_id',
    'tanggal_pinjam',
    'tanggal_jatuh_tempo',
    'tanggal_kembali',
    'status',
];
    public function petugas()
    {
    return $this->belongsTo(User::class, 'petugas_id');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class, 'peminjaman_id');
    }
}
