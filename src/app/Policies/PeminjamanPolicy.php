<?php

namespace App\Policies;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeminjamanPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list peminjaman.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail peminjaman.
     */
    public function view(User $user, Peminjaman $peminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan membuat peminjaman.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit peminjaman.
     */
    public function update(User $user, Peminjaman $peminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan hapus peminjaman.
     */
    public function delete(User $user, Peminjaman $peminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak peminjaman.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen peminjaman.
     */
    public function forceDelete(User $user, Peminjaman $peminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen banyak peminjaman.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan restore peminjaman.
     */
    public function restore(User $user, Peminjaman $peminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak peminjaman.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi peminjaman.
     */
    public function replicate(User $user, Peminjaman $peminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan reorder peminjaman.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
