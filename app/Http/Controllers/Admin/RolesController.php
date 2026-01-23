<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ListPermissions;
use App\Actions\Admin\ListRoles;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RolesController extends Controller
{
    public function __invoke(ListRoles $listRoles, ListPermissions $listPermissions, Request $request): Response
    {
        return Inertia::render('admin/Roles', [
            'roles' => $listRoles->execute(),
            'permissions' => $listPermissions->execute(),
            'canEditRoles' => $request->user()?->can('editRoles') ?? false,
        ]);
    }
}
