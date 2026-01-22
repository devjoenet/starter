<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\RoleCreateData;
use App\Models\Role;

class CreateRole
{
    public function execute(RoleCreateData $data): Role
    {
        return Role::query()->create([
            'name' => $data->name,
            'guard_name' => config('auth.defaults.guard'),
        ]);
    }
}
