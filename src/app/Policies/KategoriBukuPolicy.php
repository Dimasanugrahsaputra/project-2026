<?php

namespace App\Policies;

use App\Models\KategoriBuku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriBukuPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list kategori buku.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail kategori buku.
     */
    public function view(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    /**
     * Izinkan membuat kategori buku.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit kategori buku.
     */
    public function update(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus kategori buku.
     */
    public function delete(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak kategori buku.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen kategori buku.
     */
    public function forceDelete(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen banyak kategori buku.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan restore kategori buku.
     */
    public function restore(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak kategori buku.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi kategori buku.
     */
    public function replicate(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    /**
     * Izinkan reorder kategori buku.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
