<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public const array ROLES = [
        [
            'name' => 'superAdmin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'admin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'user',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'guest',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    public function run(): void
    {
        Role::create(self::ROLES);
    }
}
