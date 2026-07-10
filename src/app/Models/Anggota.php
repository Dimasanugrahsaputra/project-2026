<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggota extends Model
{
    protected $table = 'anggotas';

    protected $fillable = [
        'user_id',
        'kode_anggota',
        'nama_lengkap',
        'email',
        'no_hp',
        'alamat',
        'tanggal_bergabung',
        'status',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return in_array(
            strtolower((string) $this->status),
            ['aktif', 'active'],
            true
        );
    }
}
