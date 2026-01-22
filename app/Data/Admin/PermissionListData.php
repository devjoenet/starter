<?php

declare(strict_types=1);

namespace App\Data\Admin;

use App\Models\Permission;
use Spatie\LaravelData\Data;

class PermissionListData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $guardName,
        public int $rolesCount,
        public string $createdAt,
    ) {}

    public static function fromModel(Permission $permission): self
    {
        return new self(
            $permission->id,
            $permission->name,
            $permission->guard_name,
            $permission->roles_count ?? 0,
            $permission->created_at?->toDateTimeString() ?? '',
        );
    }
}
