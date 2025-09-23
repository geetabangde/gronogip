<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RetailerDashboardController;
use App\Http\Controllers\ManufacturerDashboardController;
use App\Http\Controllers\Backend\BrandController; 
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Middleware\CheckRole;

// Home route
Route::get('/', fn() => view('welcome'));

// ================= LOGIN / LOGOUT ================= //
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});
Route::middleware(['auth:admin', CheckRole::class . ':1,'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/brands', [AdminDashboardController::class, 'listBrands'])->name('admin.brand.list');
    Route::get('/admin/products', [AdminDashboardController::class, 'listProducts'])->name('admin.product.list');
    Route::get('/admin/orders', [AdminDashboardController::class, 'listOrders'])->name('admin.order.list');
    Route::get('/admin/manufacturers', [AdminDashboardController::class, 'listManufacturers'])->name('admin.manufacturers.list');
    Route::delete('/admin/manufacturer/{id}', [AdminDashboardController::class,'deleteManufacturer'])->name('admin.manufacturer.delete');
    Route::get('/admin/manufacturers/create', [AdminDashboardController::class,'createManufacturer'])->name('admin.manufacturers.create'); 
    Route::post('/admin/manufacturers/create', [AdminDashboardController::class,'storeManufacturer'])->name('admin.manufacturers.store');
    Route::get('/admin/manufacturers', [AdminDashboardController::class, 'listManufacturers'])->name('admin.manufacturers.list');
    Route::delete('/admin/manufacturer/{id}', [AdminDashboardController::class,'deleteManufacturer'])->name('admin.manufacturer.delete'); 
    Route::get('/admin/manufacturer/{id}/edit', [AdminDashboardController::class,'editManufacturer'])->name('admin.manufacturers.edit');
    Route::put('/admin/manufacturer/{id}', [AdminDashboardController::class,'updateManufacturer'])->name('admin.manufacturers.update');
});
Route::middleware(['auth:admin', CheckRole::class . ':2'])->group(function () {
    Route::get('/retailer/dashboard', [RetailerDashboardController::class, 'index'])->name('retailer.dashboard');
});
Route::middleware(['auth:admin', CheckRole::class . ':3'])->group(function () {
    Route::get('/manufacturer/dashboard', [ManufacturerDashboardController::class, 'index'])->name('manufacturer.dashboard');
    // brand routes
    Route::get('/manufacturer/brands', [BrandController::class, 'index'])->name('admin.brand.index'); 
    Route::get('/manufacturer/brands/create', [BrandController::class,'create'])->name('admin.brand.create'); 
    Route::post('/manufacturer/brands', [BrandController::class,'store'])->name('admin.brand.store'); 
    Route::get('/manufacturer/brands/{id}/edit', [BrandController::class,'edit'])->name('admin.brand.edit'); 
    Route::put('/manufacturer/brands/{id}', [BrandController::class,'update'])->name('admin.brand.update'); 
    Route::delete('/manufacturer/brands/{id}', [BrandController::class,'destroy'])->name('admin.brand.delete'); 
    
    // product routes
    Route::get('/manufacturer/products', [ProductController::class, 'index'])->name('admin.product.index'); 
    Route::get('/manufacturer/products/create', [ProductController::class,'create'])->name('admin.product.create'); 
    Route::post('/manufacturer/products', [ProductController::class,'store'])->name('admin.product.store'); 
    Route::get('/manufacturer/products/{id}/edit', [ProductController::class,'edit'])->name('admin.product.edit'); 
    Route::put('/manufacturer/products/{id}', [ProductController::class,'update'])->name('admin.product.update'); 
    Route::delete('/manufacturer/products/{id}', [ProductController::class,'destroy'])->name('admin.product.delete');
    // order list routes
    Route::get('/manufacturer/orders', [OrderController::class, 'listOrders'])->name('manufacturer.orders.list');
    Route::get('/manufacturer/order/{id}', [OrderController::class, 'showOrder'])->name('admin.order.show');
    Route::put('/manufacturer/order/{id}', [OrderController::class, 'updateOrderStatus'])->name('admin.order.update');
});
 