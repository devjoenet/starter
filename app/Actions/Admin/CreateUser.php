<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Data\Admin\UserCreateData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function execute(UserCreateData $data): User
    {
        return User::query()->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }
}
