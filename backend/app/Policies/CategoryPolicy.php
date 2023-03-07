<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy extends AbstractPolicy
{
    public function index(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function updateOrCreate(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user): bool
    {
        return $this->isAdmin($user);
    }
}
