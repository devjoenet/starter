<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\PermissionListData;
use App\Models\Permission;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class ListPermissions
{
    public function execute(): DataCollection|Collection
    {
        $permissions = Permission::query()
            ->withCount('roles')
            ->orderBy('name')
            ->get();

        return PermissionListData::collect($permissions);
    }
}
