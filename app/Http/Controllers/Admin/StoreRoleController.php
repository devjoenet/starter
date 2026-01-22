<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateRole;
use App\Data\Admin\RoleCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use Illuminate\Http\RedirectResponse;

class StoreRoleController extends Controller
{
    public function __invoke(StoreRoleRequest $request, CreateRole $createRole): RedirectResponse
    {
        $createRole->execute(RoleCreateData::from($request->validated()));

        return to_route('admin.roles.index');
    }
}
