<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\ListUsers;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class UsersController extends Controller
{
    public function __invoke(ListUsers $listUsers): Response
    {
        return Inertia::render('admin/Users', [
            'users' => $listUsers->execute(),
        ]);
    }
}
