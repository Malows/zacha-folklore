<?php

namespace App\Domain;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserDomain
{
/**
     * Update and sync the roles associated to a user
     *
     * @param  User  $user
     * @param  string[]  $roles
     */
    public static function updateRoles(User $user, array $roles): User
    {
        $ids = Role::query()
            ->where('guard_name', 'api')
            ->whereIn('name', $roles)
            ->pluck('id');

        $user->roles()->sync($ids);

        return $user;
    }
}
