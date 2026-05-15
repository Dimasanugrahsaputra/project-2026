<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggotas';

    protected $fillable = [
        'user_id',
        'kode_anggota',
        'tanggal_bergabung',
        'status',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjamen()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }
}
