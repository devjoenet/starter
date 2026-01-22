<?php

declare(strict_types=1);

namespace App\Data\Admin;

use App\Models\Role;
use Spatie\LaravelData\Data;

class RoleListData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $guardName,
        public int $permissionsCount,
        public int $usersCount,
        public string $createdAt,
        /**
         * @var array<int, int>
         */
        public array $permissionIds,
    ) {}

    public static function fromModel(Role $role): self
    {
        return new self(
            $role->id,
            $role->name,
            $role->guard_name,
            $role->permissions_count ?? 0,
            $role->users_count ?? 0,
            $role->created_at?->toDateTimeString() ?? '',
            $role->permissions->pluck('id')->all(),
        );
    }
}
