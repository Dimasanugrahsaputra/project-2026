<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RakBuku extends Model
{
    protected $table = 'rak_bukus';

    protected $fillable = [
        'kode_rak',
        'nama_rak',
        'lokasi_rak',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'rak_buku_id');
    }
}
