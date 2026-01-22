<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreatePermission;
use App\Data\Admin\PermissionCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionRequest;
use Illuminate\Http\RedirectResponse;

class StorePermissionController extends Controller
{
    public function __invoke(StorePermissionRequest $request, CreatePermission $createPermission): RedirectResponse
    {
        $createPermission->execute(PermissionCreateData::from($request->validated()));

        return to_route('admin.permissions.index');
    }
}
