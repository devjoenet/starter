<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates a user from the admin modal', function () {
    $admin = User::factory()->create();
    $role = Role::query()->create([
        'name' => 'Customer Success',
        'guard_name' => config('auth.defaults.guard'),
    ]);

    $this->actingAs($admin);

    $payload = [
        'name' => 'Southeast Admin',
        'email' => 'admin@southeastcode.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role_id' => $role->id,
    ];

    $response = $this->post(route('admin.users.store'), $payload);

    $response->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'name' => 'Southeast Admin',
        'email' => 'admin@southeastcode.com',
    ]);

    $createdUser = User::query()->where('email', 'admin@southeastcode.com')->firstOrFail();

    $this->assertDatabaseHas('model_has_roles', [
        'role_id' => $role->id,
        'model_id' => $createdUser->id,
        'model_type' => User::class,
    ]);
});

it('creates a role from the admin modal', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin);

    $response = $this->post(route('admin.roles.store'), [
        'name' => 'Creative Director',
    ]);

    $response->assertRedirect(route('admin.roles.index'));

    $this->assertDatabaseHas('roles', [
        'name' => 'Creative Director',
        'guard_name' => config('auth.defaults.guard'),
    ]);
});

it('creates a permission from the admin modal', function () {
    $admin = User::factory()->create();

    $this->actingAs($admin);

    $response = $this->post(route('admin.permissions.store'), [
        'name' => 'edit client brief',
    ]);

    $response->assertRedirect(route('admin.permissions.index'));

    $this->assertDatabaseHas('permissions', [
        'name' => 'edit client brief',
        'guard_name' => config('auth.defaults.guard'),
    ]);
});
