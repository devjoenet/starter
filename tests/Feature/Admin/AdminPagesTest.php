<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests away from admin pages', function (string $routeName) {
    $response = $this->get(route($routeName), ['X-Inertia' => 'true']);

    $response->assertRedirect(route('login'));
})->with('adminPages');

it('allows authenticated users to view admin pages', function (string $routeName) {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->get(route($routeName), ['X-Inertia' => 'true']);

    $response->assertOk();
})->with('adminPages');

dataset('adminPages', [
    'users' => ['admin.users.index'],
    'roles' => ['admin.roles.index'],
    'permissions' => ['admin.permissions.index'],
]);
