<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\RoleCreateData;
use App\Models\Role;

class CreateRole
{
    public function execute(RoleCreateData $data): Role
    {
        $role = Role::query()->create([
            'name' => $data->name,
            'guard_name' => config('auth.defaults.guard'),
        ]);

        $permissions = collect($data->permissions)
            ->map(static fn (int|string $permissionId): int => (int) $permissionId)
            ->filter()
            ->values()
            ->all();

        $role->syncPermissions($permissions);

        return $role;
    }
}
