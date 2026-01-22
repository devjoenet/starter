<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\CreateUser;
use App\Data\Admin\UserCreateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use Illuminate\Http\RedirectResponse;

class StoreUserController extends Controller
{
    public function __invoke(StoreUserRequest $request, CreateUser $createUser): RedirectResponse
    {
        $createUser->execute(UserCreateData::from($request->validated()));

        return to_route('admin.users.index');
    }
}
