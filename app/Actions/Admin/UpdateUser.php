<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\UserUpdateData;
use App\Models\Role;
use App\Models\User;

class UpdateUser
{
    public function execute(User $user, UserUpdateData $data): User
    {
        $user->update([
            'name' => $data->name,
            'email' => $data->email,
        ]);

        $role = Role::query()->findOrFail($data->roleId);
        $user->syncRoles([$role]);

        return $user;
    }
}
