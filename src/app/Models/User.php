<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_ANGGOTA = 'anggota';

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

    public function anggota(): HasOne
    {
        return $this->hasOne(
            Anggota::class,
            'user_id'
        );
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN
            || $this->hasRole(self::ROLE_ADMIN);
    }

    public function isAnggota(): bool
    {
        return $this->role === self::ROLE_ANGGOTA
            || $this->hasRole(self::ROLE_ANGGOTA);
    }

    public function isActiveAnggota(): bool
    {
        $this->loadMissing('anggota');

        if (! $this->isAnggota()) {
            return false;
        }

        if (! $this->anggota) {
            return false;
        }

        $statusAnggota = strtolower(
            trim((string) $this->anggota->status)
        );

        $statusUser = strtolower(
            trim((string) ($this->status ?? 'aktif'))
        );

        $statusAktif = [
            'aktif',
            'active',
        ];

        return in_array(
            $statusAnggota,
            $statusAktif,
            true
        ) && in_array(
            $statusUser,
            $statusAktif,
            true
        );
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }
}