<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\StorePermissionController;
use App\Http\Controllers\Admin\StoreRoleController;
use App\Http\Controllers\Admin\StoreUserController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('users', UsersController::class)->name('users.index');
        Route::post('users', StoreUserController::class)->name('users.store');
        Route::get('roles', RolesController::class)->name('roles.index');
        Route::post('roles', StoreRoleController::class)->name('roles.store');
        Route::get('permissions', PermissionsController::class)->name('permissions.index');
        Route::post('permissions', StorePermissionController::class)->name('permissions.store');
    });

require __DIR__.'/settings.php';
