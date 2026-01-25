<?php

declare(strict_types=1);

namespace App\Models;

use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission implements PermissionContract
{
    public ?string $group;
}
