<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RetailerDashboardController;
use App\Http\Controllers\ManufacturerDashboardController;
use App\Http\Controllers\Backend\BrandController; 
use App\Http\Controllers\Backend\ProductController;
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
    // brand routes
    Route::get('/manufacturer/brands', [BrandController::class, 'index'])->name('admin.brand.index'); // list brands
    Route::get('/manufacturer/brands/create', [BrandController::class,'create'])->name('admin.brand.create'); // add brand form
    Route::post('/manufacturer/brands', [BrandController::class,'store'])->name('admin.brand.store'); // save brand
    Route::get('/manufacturer/brands/{id}/edit', [BrandController::class,'edit'])->name('admin.brand.edit'); // edit brand form
    Route::put('/manufacturer/brands/{id}', [BrandController::class,'update'])->name('admin.brand.update'); // update brand
    Route::delete('/manufacturer/brands/{id}', [BrandController::class,'destroy'])->name('admin.brand.delete'); // delete brand
    // product routes
    
    Route::get('/manufacturer/products', [ProductController::class, 'index'])->name('admin.product.index'); // list products
    Route::get('/manufacturer/products/create', [ProductController::class,'create'])->name('admin.product.create'); // add product form
    Route::post('/manufacturer/products', [ProductController::class,'store'])->name('admin.product.store'); // save product
    Route::get('/manufacturer/products/{id}/edit', [ProductController::class,'edit'])->name('admin.product.edit'); // edit product form
    Route::put('/manufacturer/products/{id}', [ProductController::class,'update'])->name('admin.product.update'); // update product
    Route::delete('/manufacturer/products/{id}', [ProductController::class,'destroy'])->name('admin.product.delete'); // delete product
});
 