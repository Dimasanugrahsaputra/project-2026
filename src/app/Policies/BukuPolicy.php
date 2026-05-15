<?php

namespace App\Policies;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BukuPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list buku.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail buku.
     */
    public function view(User $user, Buku $buku): bool
    {
        return true;
    }

    /**
     * Izinkan membuat buku.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit buku.
     */
    public function update(User $user, Buku $buku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus buku.
     */
    public function delete(User $user, Buku $buku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak buku.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen buku.
     */
    public function forceDelete(User $user, Buku $buku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen banyak buku.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan restore buku.
     */
    public function restore(User $user, Buku $buku): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak buku.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi buku.
     */
    public function replicate(User $user, Buku $buku): bool
    {
        return true;
    }

    /**
     * Izinkan reorder buku.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
