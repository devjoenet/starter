<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\RoleListData;
use App\Models\Role;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class ListRoles
{
    public function execute(): DataCollection|Collection
    {
        $roles = Role::query()
            ->withCount(['permissions', 'users'])
            ->orderBy('name')
            ->get();

        return RoleListData::collect($roles);
    }
}
