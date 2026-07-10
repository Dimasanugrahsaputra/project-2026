<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
    'anggota_id',
    'kode_peminjaman',
    'tanggal_pengajuan',
    'tanggal_rencana_pengambilan',
    'tanggal_pinjam',
    'tanggal_jatuh_tempo',
    'tanggal_kembali',
    'status',
    'catatan_anggota',
    'catatan_admin',
];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_rencana_pengambilan' => 'date',
        'tanggal_pinjam' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_kembali' => 'date',
    ];


    public function anggota(): BelongsTo
    {
        return $this->belongsTo(
            Anggota::class,
            'anggota_id'
        );
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'peminjaman_id'
        );
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->details();
    }

    public function detailPeminjamans(): HasMany
    {
        return $this->details();
    }

    public function pengembalianBuku(): HasOne
    {
        return $this->hasOne(
            PengembalianBuku::class,
            'peminjaman_id'
        );
    }
}
