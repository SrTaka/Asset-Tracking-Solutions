<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedAdminController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AssetController;
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

    // Asset Management Routes
    Route::get('assets', [AssetController::class, 'index'])->name('admin.assets.index');
    Route::get('assets/create', [AssetController::class, 'create'])->name('admin.assets.create');
    // Export and Import Routes (static paths before dynamic {asset} routes)
    Route::get('assets/export', [AssetController::class, 'export'])->name('admin.assets.export');
    Route::get('assets/import', [AssetController::class, 'importForm'])->name('admin.assets.import.form');
    Route::post('assets/import', [AssetController::class, 'import'])->name('admin.assets.import');
    Route::get('assets/import/template', [AssetController::class, 'downloadImportTemplate'])->name('admin.assets.import.template');

    Route::post('assets', [AssetController::class, 'store'])->name('admin.assets.store');
    Route::get('assets/{asset}', [AssetController::class, 'show'])->name('admin.assets.show');
    Route::get('assets/{asset}/edit', [AssetController::class, 'edit'])->name('admin.assets.edit');
    Route::put('assets/{asset}', [AssetController::class, 'update'])->name('admin.assets.update');
    Route::delete('assets/{asset}', [AssetController::class, 'destroy'])->name('admin.assets.destroy');
    Route::get('assets/{asset}/qr-code', [AssetController::class, 'generateQrCode'])->name('admin.assets.qr-code');
    Route::get('assets/{asset}/qr', [AssetController::class, 'streamQrCode'])->name('admin.assets.qr');

    // User Management Routes
    Route::get('users', [UserManagementController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('users/{id}', [UserManagementController::class, 'show'])->name('admin.users.show');
    Route::get('users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{id}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});
