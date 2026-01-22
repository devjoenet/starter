<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\UpdateRole;
use App\Data\Admin\RoleUpdateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;

class UpdateRoleController extends Controller
{
    public function __invoke(UpdateRoleRequest $request, Role $role, UpdateRole $updateRole): RedirectResponse
    {
        $updateRole->execute($role, RoleUpdateData::from($request->validated()));

        return to_route('admin.roles.index');
    }
}
