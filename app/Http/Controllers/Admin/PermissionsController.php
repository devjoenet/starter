<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ListPermissions;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class PermissionsController extends Controller
{
    public function __invoke(ListPermissions $listPermissions): Response
    {
        return Inertia::render('admin/Permissions', [
            'permissions' => $listPermissions->execute(),
        ]);
    }
}
