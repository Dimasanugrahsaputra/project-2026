<?php

namespace App\Policies;

use App\Models\Denda;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DendaPolicy
{
    use HandlesAuthorization;

    /**
     * Izinkan melihat menu/list denda.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan melihat detail denda.
     */
    public function view(User $user, Denda $denda): bool
    {
        return true;
    }

    /**
     * Izinkan membuat denda.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan edit denda.
     */
    public function update(User $user, Denda $denda): bool
    {
        return true;
    }

    /**
     * Izinkan hapus denda.
     */
    public function delete(User $user, Denda $denda): bool
    {
        return true;
    }

    /**
     * Izinkan hapus banyak denda.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen denda.
     */
    public function forceDelete(User $user, Denda $denda): bool
    {
        return true;
    }

    /**
     * Izinkan hapus permanen banyak denda.
     */
    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan restore denda.
     */
    public function restore(User $user, Denda $denda): bool
    {
        return true;
    }

    /**
     * Izinkan restore banyak denda.
     */
    public function restoreAny(User $user): bool
    {
        return true;
    }

    /**
     * Izinkan duplikasi denda.
     */
    public function replicate(User $user, Denda $denda): bool
    {
        return true;
    }

    /**
     * Izinkan reorder denda.
     */
    public function reorder(User $user): bool
    {
        return true;
    }
}
