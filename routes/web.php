<?php

use App\Http\Controllers\admin\ADashboardController;
use App\Http\Controllers\admin\PermissionsController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home
Route::group([], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});

// Admin
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        // Admin Dashbaord
        Route::get('dashboard', [ADashboardController::class, 'dashbaord'])->name('admin.dashboard');

        Route::resource('permissions', PermissionsController::class);
        Route::resource('roles', RolesController::class);
        Route::post('/modifier-permissions/{id}', [RolesController::class, 'updatePermissions'])->name('addPermissions');
        Route::resource('users', UsersController::class);
        Route::put('/users-toggle-active/{user}', [UsersController::class, 'toggleActive'])->name('users.active');
        Route::put('/users-toggle-verify/{user}', [UsersController::class, 'toggleVerify'])->name('users.verify');

        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::put('/settings', [SettingController::class, 'update'])
            ->name('settings.update');

        Route::delete('/settings/image/{key}', [SettingController::class, 'destroyImage'])
            ->name('settings.image.destroy');
    });

Route::middleware([
    'auth',
    'role:admin|editor|blogger'
])
->prefix('admin')
->group(function () {

    Route::get('dashboard', [ADashboardController::class, 'dashbaord'])->name('admin.dashboard');

    // Other admin routes
});

// User
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->group(function () {

    });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
