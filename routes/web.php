<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/****Controller** */
use App\Http\Controllers\AdminSetting\UserController;
use App\Http\Controllers\AdminSetting\RoleController;
use App\Http\Controllers\AdminSetting\LogController;

use App\Http\Controllers\CommonFields\DepartmentController;
use App\Http\Controllers\CommonFields\BuildingController;
use App\Http\Controllers\CommonFields\FloorController;
use App\Http\Controllers\CommonFields\LocationTypeController;
use App\Http\Controllers\CommonFields\LocationController;
use App\Http\Controllers\CommonFields\DepreciationController;
use App\Http\Controllers\CommonFields\CondemnationController;





Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::prefix('admin-settings')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    /** 🧩 Role Management */
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
});

Route::prefix('common-fields')->name('common.')->group(function () {

    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
    Route::get('/floors', [FloorController::class, 'index'])->name('floors.index');
    Route::get('/location-types', [LocationTypeController::class, 'index'])->name('locationTypes.index');
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/depreciations', [DepreciationController::class, 'index'])->name('depreciations.index');
    Route::get('/condemnations', [CondemnationController::class, 'index'])->name('condemnations.index');
});







Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
