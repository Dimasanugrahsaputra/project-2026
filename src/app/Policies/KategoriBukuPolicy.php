<?php

namespace App\Policies;

use App\Models\KategoriBuku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class KategoriBukuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    public function delete(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    public function deleteAny(User $user): bool
    {
        return true;
    }

    public function forceDelete(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    public function restore(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    public function restoreAny(User $user): bool
    {
        return true;
    }

    public function replicate(User $user, KategoriBuku $kategoriBuku): bool
    {
        return true;
    }

    public function reorder(User $user): bool
    {
        return true;
    }
}
