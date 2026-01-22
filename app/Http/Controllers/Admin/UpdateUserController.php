<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\UpdateUser;
use App\Data\Admin\UserUpdateData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class UpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request, UpdateUser $updateUser, User $user): RedirectResponse
    {
        $updateUser->execute($user, UserUpdateData::from($request->validated()));

        return to_route('admin.users.index');
    }
}
