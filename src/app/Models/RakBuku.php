<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RakBuku extends Model
{
    use HasFactory;

    protected $table = 'rak_bukus';

    protected $fillable = [
        'nama_rak',
        'kode_rak',
        'lokasi_rak',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'rak_buku_id');
    }
}
