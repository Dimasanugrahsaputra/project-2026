<?php

namespace App\Policies;

use App\Models\PengembalianBuku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PengembalianBukuPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list pengembalian buku.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail pengembalian buku.
     */
    public function view(User $user, PengembalianBuku $pengembalianBuku): bool
    {
        return true;
    }

    /**
     * Izinkan membuat pengembalian buku.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit pengembalian buku.
     */
    public function update(User $user, PengembalianBuku $pengembalianBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus pengembalian buku.
     */
    public function delete(User $user, PengembalianBuku $pengembalianBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak pengembalian buku.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen pengembalian buku.
     */
    public function forceDelete(User $user, PengembalianBuku $pengembalianBuku): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen banyak pengembalian buku.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan restore pengembalian buku.
     */
    public function restore(User $user, PengembalianBuku $pengembalianBuku): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak pengembalian buku.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi pengembalian buku.
     */
    public function replicate(User $user, PengembalianBuku $pengembalianBuku): bool
    {
        return true;
    }

    /**
     * Izinkan reorder pengembalian buku.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
