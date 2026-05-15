<?php

namespace App\Policies;

use App\Models\DetailPeminjaman;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DetailPeminjamanPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list detail peminjaman.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail data.
     */
    public function view(User $user, DetailPeminjaman $detailPeminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan membuat detail peminjaman.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit detail peminjaman.
     */
    public function update(User $user, DetailPeminjaman $detailPeminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan hapus detail peminjaman.
     */
    public function delete(User $user, DetailPeminjaman $detailPeminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak detail peminjaman.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen.
     */
    public function forceDelete(User $user, DetailPeminjaman $detailPeminjaman): bool
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
     * Izinkan restore.
     */
    public function restore(User $user, DetailPeminjaman $detailPeminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak data.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi data.
     */
    public function replicate(User $user, DetailPeminjaman $detailPeminjaman): bool
    {
        return true;
    }

    /**
     * Izinkan reorder data.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
