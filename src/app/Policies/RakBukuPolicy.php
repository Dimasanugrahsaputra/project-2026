<?php

namespace App\Policies;

use App\Models\RakBuku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RakBukuPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list rak buku.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail rak buku.
     */
    public function view(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    /**
     * Izinkan membuat rak buku.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit rak buku.
     */
    public function update(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus rak buku.
     */
    public function delete(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak rak buku.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen rak buku.
     */
    public function forceDelete(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen banyak rak buku.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan restore rak buku.
     */
    public function restore(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak rak buku.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi rak buku.
     */
    public function replicate(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    /**
     * Izinkan reorder rak buku.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
