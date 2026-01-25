<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\PermissionCreateData;
use App\Models\Permission;

class CreatePermission
{
    public function execute(PermissionCreateData $data): Permission
    {
        return Permission::query()->create([
            'name' => $data->name,
            'group' => $data->group,
            'guard_name' => config('auth.defaults.guard'),
        ]);
    }
}
