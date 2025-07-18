<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedAdminController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedAdminController::class, 'create'])
        ->name('admin.login');
    Route::post('login', [AuthenticatedAdminController::class, 'store']);

});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Admin Dashboard
        Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::post('logout', [AuthenticatedAdminController::class, 'destroy'])
        ->name('admin.logout');
});
