<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RetailerDashboardController;
use App\Http\Controllers\ManufacturerDashboardController;
use App\Http\Middleware\CheckRole;

// Home route
Route::get('/', fn() => view('welcome'));

// ================= LOGIN / LOGOUT ================= //
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});



Route::middleware(['auth:admin', CheckRole::class . ':1'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

Route::middleware(['auth:admin', CheckRole::class . ':2'])->group(function () {
    Route::get('/retailer/dashboard', [RetailerDashboardController::class, 'index'])->name('retailer.dashboard');
});

Route::middleware(['auth:admin', CheckRole::class . ':3'])->group(function () {
    Route::get('/manufacturer/dashboard', [ManufacturerDashboardController::class, 'index'])->name('manufacturer.dashboard');
});

