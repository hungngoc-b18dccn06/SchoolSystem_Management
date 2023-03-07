<?php

namespace App\Policies;

use App\Enums\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class AbstractPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function isAdmin($user): bool
    {
        return $user->role == Role::ADMIN;
    }

    public function isEditor($user): bool
    {
        return $user->role == Role::USER;
    }
}
