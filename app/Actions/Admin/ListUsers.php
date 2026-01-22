<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\UserListData;
use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class ListUsers
{
    public function execute(): DataCollection|Collection
    {
        $users = User::query()
            ->with('roles')
            ->orderBy('name')
            ->get();

        return UserListData::collect($users);
    }
}
