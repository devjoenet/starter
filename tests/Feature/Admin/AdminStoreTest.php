<?php

declare(strict_types=1);

use App\Models\Permission;
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

it('updates a user from the admin modal', function () {
    $admin = User::factory()->create();
    $originalRole = Role::query()->create([
        'name' => 'Account Manager',
        'guard_name' => config('auth.defaults.guard'),
    ]);
    $newRole = Role::query()->create([
        'name' => 'Team Lead',
        'guard_name' => config('auth.defaults.guard'),
    ]);
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    $user->assignRole($originalRole);

    $this->actingAs($admin);

    $response = $this->patch(route('admin.users.update', $user), [
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'role_id' => $newRole->id,
    ]);

    $response->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
    ]);

    $this->assertDatabaseHas('model_has_roles', [
        'role_id' => $newRole->id,
        'model_id' => $user->id,
        'model_type' => User::class,
    ]);

    $this->assertDatabaseMissing('model_has_roles', [
        'role_id' => $originalRole->id,
        'model_id' => $user->id,
        'model_type' => User::class,
    ]);
});

it('creates a role from the admin modal', function () {
    $admin = User::factory()->create();
    $permission = Permission::query()->create([
        'name' => 'manage brand assets',
        'guard_name' => config('auth.defaults.guard'),
    ]);

    $this->actingAs($admin);

    $response = $this->post(route('admin.roles.store'), [
        'name' => 'Creative Director',
        'permissions' => [$permission->id],
    ]);

    $response->assertRedirect(route('admin.roles.index'));

    $this->assertDatabaseHas('roles', [
        'name' => 'Creative Director',
        'guard_name' => config('auth.defaults.guard'),
    ]);

    $role = Role::query()->where('name', 'Creative Director')->firstOrFail();

    $this->assertDatabaseHas('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
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

it('updates a role with permissions from the admin modal', function () {
    $admin = User::factory()->create();
    $permission = Permission::query()->create([
        'name' => 'view invoices',
        'guard_name' => config('auth.defaults.guard'),
    ]);
    $secondPermission = Permission::query()->create([
        'name' => 'export invoices',
        'guard_name' => config('auth.defaults.guard'),
    ]);
    $role = Role::query()->create([
        'name' => 'Billing',
        'guard_name' => config('auth.defaults.guard'),
    ]);

    $role->syncPermissions([$permission]);

    $this->actingAs($admin);

    $response = $this->patch(route('admin.roles.update', $role), [
        'name' => 'Billing Lead',
        'permissions' => [$secondPermission->id],
    ]);

    $response->assertRedirect(route('admin.roles.index'));

    $this->assertDatabaseHas('roles', [
        'id' => $role->id,
        'name' => 'Billing Lead',
    ]);

    $this->assertDatabaseHas('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $secondPermission->id,
    ]);

    $this->assertDatabaseMissing('role_has_permissions', [
        'role_id' => $role->id,
        'permission_id' => $permission->id,
    ]);
});
