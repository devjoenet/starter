<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ListRoles;
use App\Actions\Admin\ListUsers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function __invoke(ListUsers $listUsers, ListRoles $listRoles, Request $request): Response
    {
        return Inertia::render('admin/Users', [
            'users' => $listUsers->execute(),
            'roles' => $listRoles->execute(),
            'canEditUsers' => $request->user()?->can('editUsers') ?? false,
        ]);
    }
}
