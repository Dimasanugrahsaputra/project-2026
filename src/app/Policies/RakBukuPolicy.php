<?php

namespace App\Policies;

use App\Models\RakBuku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RakBukuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    public function delete(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    public function deleteAny(User $user): bool
    {
        return true;
    }

    public function forceDelete(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    public function forceDeleteAny(User $user): bool
    {
        return true;
    }

    public function restore(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    public function restoreAny(User $user): bool
    {
        return true;
    }

    public function replicate(User $user, RakBuku $rakBuku): bool
    {
        return true;
    }

    public function reorder(User $user): bool
    {
        return true;
    }
}
