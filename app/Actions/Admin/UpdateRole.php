<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\RoleUpdateData;
use App\Models\Role;

class UpdateRole
{
    public function execute(Role $role, RoleUpdateData $data): Role
    {
        $role->update([
            'name' => $data->name,
        ]);

        $role->syncPermissions($data->permissions);

        return $role;
    }
}
