<?php

declare(strict_types=1);

use App\Models\Role;
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

it('renders the users page with roles', function () {
    $user = User::factory()->create();
    Role::query()->create([
        'name' => 'Account Lead',
        'guard_name' => config('auth.defaults.guard'),
    ]);

    $this->actingAs($user);

    $response = $this->get(route('admin.users.index'), [
        'Accept' => 'application/json',
        'X-Inertia' => 'true',
    ]);

    $response->assertOk();
    $response->assertJsonPath('component', 'admin/Users');
    $response->assertJsonPath('props.roles.0.name', 'Account Lead');
});

dataset('adminPages', [
    'users' => ['admin.users.index'],
    'roles' => ['admin.roles.index'],
    'permissions' => ['admin.permissions.index'],
]);
