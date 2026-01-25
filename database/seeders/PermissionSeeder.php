<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public const array PERMISSIONS = [
        // Users
        [
            'name' => 'users.view',
            'group' => 'users',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'users.create',
            'group' => 'users',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'users.edit',
            'group' => 'users',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'users.delete',
            'group' => 'users',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],

        // Roles
        [
            'name' => 'roles.view',
            'group' => 'roles',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'roles.create',
            'group' => 'roles',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'roles.edit',
            'group' => 'roles',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'roles.delete',
            'group' => 'roles',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],

        // Permissions
        [
            'name' => 'permissions.view',
            'group' => 'permissions',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'permissions.create',
            'group' => 'permissions',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'permissions.edit',
            'group' => 'permissions',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'permissions.delete',
            'group' => 'permissions',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    public function run(): void
    {
        Permission::insert(self::PERMISSIONS);
    }
}
