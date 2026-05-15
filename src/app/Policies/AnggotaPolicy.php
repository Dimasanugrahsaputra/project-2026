<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnggotaPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list anggota.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail anggota.
     */
    public function view(User $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Izinkan membuat anggota.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit anggota.
     */
    public function update(User $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Izinkan hapus anggota.
     */
    public function delete(User $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak anggota.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen.
     */
    public function forceDelete(User $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen banyak data.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan restore anggota.
     */
    public function restore(User $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak anggota.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi anggota.
     */
    public function replicate(User $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Izinkan reorder anggota.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
