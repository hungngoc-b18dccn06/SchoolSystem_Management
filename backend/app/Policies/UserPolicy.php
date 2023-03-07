<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends AbstractPolicy
{
    public function index(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function detail(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function store(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function update(User $user): bool
    {
        return $this->isAdmin($user);
    }

    public function delete(User $user): bool
    {
        return $this->isAdmin($user);
    }
}
