<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('forgotPassword', [UserController::class, 'validatePasswordRequest'])->name('forgotPassword');
Route::get('password/reset/{token}', [UserController::class, 'passwordReset'])->name('password.reset');
Route::post('password/reset', [UserController::class, 'changePasswordPost'])->name('password.resetPassword');
Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::group(['prefix' => 'country'], function () {
        Route::get('/', [CountryController::class, 'index'])->name('admin.country');
        Route::get('/create', [CountryController::class, 'create'])->name('admin.country.create');
        Route::post('/store', [CountryController::class, 'store'])->name('admin.country.store');
        Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('admin.country.edit');
        Route::put('/edit/{id}', [CountryController::class, 'update'])->name('admin.country.update');
        Route::get('/delete/{id}', [CountryController::class, 'delete'])->name('admin.country.delete');
    });

    // permission
    Route::group(['prefix' => 'permission'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('admin.permission');
        Route::get('/create', [PermissionController::class, 'create'])->name('admin.permission.create');
        Route::post('/create', [PermissionController::class, 'store'])->name('admin.permission.store');
        Route::get('edit/{id}', [PermissionController::class, 'edit'])->name('admin.permission.edit');
        Route::post('edit/{id}', [PermissionController::class, 'update'])->name('admin.permission.update');
        Route::get('delete/{id}', [PermissionController::class, 'delete'])->name('admin.permission.delete');
    });

    // role
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.role');
        Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('/create', [RoleController::class, 'store'])->name('admin.role.store');
        Route::get('edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
        Route::post('edit/{id}', [RoleController::class, 'update'])->name('admin.role.update');
        Route::get('delete/{id}', [RoleController::class, 'delete'])->name('admin.role.delete');
    });

    // user
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/create', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('edit/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::get('delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
    });
});
