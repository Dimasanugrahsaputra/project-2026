<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, [
            'admin',
            'petugas',
            'kepala_perpustakaan',
        ]) && $this->status === 'aktif';
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }

    public function peminjamanYangDitangani()
    {
        return $this->hasMany(Peminjaman::class, 'petugas_id');
    }

    public function pengembalianYangDitangani()
    {
        return $this->hasMany(PengembalianBuku::class, 'petugas_id');
    }
}
