<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\ProductListingController;
use App\Http\Controllers\DemandListingController;
use App\Http\Controllers\RedeemController;

Route::get('/', function () {
    return view('welcome');
});

    Route::prefix('admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
        Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
         // Users
        Route::get('/users', [UserController::class, 'index'])->name('admin.users');

         // Order
        Route::get('/order', [OrderController::class, 'index'])->name('admin.order');
        
        // requirement
        Route::get('/requirement', [RequirementController::class, 'index'])->name('admin.requirement');

         // demand
        Route::get('/demand', [DemandController::class, 'index'])->name('admin.demand');

         // Product Listing
        Route::get('/product_listing', [ProductListingController::class, 'index'])->name('admin.product_listing');
        
         // Demand Listing
        Route::get('/demand_listing', [DemandListingController::class, 'index'])->name('admin.demand_listing');


        // Categories
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
            Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');
        });
        // SubCategories
        Route::prefix('subcategories')->group(function () {
        Route::get('/', [SubcategoryController::class, 'index'])->name('admin.subcategories.index');
        Route::post('/store', [SubcategoryController::class, 'store'])->name('admin.subcategories.store');
        Route::get('/edit/{id}', [SubcategoryController::class, 'edit'])->name('admin.subcategories.edit');
        Route::post('/update/{id}', [SubcategoryController::class, 'update'])->name('admin.subcategories.update');
        Route::delete('/delete/{id}', [SubcategoryController::class, 'destroy'])->name('admin.subcategories.destroy');
        });

        // Banners Routes
        Route::prefix('banners')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('admin.banners.index');
        Route::post('/store', [BannerController::class, 'store'])->name('admin.banners.store');
        Route::get('/edit/{id}', [BannerController::class, 'edit'])->name('admin.banners.edit');
        Route::post('/update/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
        Route::delete('/delete/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');
        });

        // Product Sell Routes
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.products.index');
            Route::post('/store', [ProductController::class, 'store'])->name('admin.products.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
            Route::post('/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');
            Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
        });

        // Product Redeem
        Route::prefix('redeem')->group(function () {
            Route::get('/', [RedeemController::class, 'index'])->name('admin.redeem.index');
            Route::post('/store', [RedeemController::class, 'store'])->name('admin.redeem.store');
            Route::get('/edit/{id}', [RedeemController::class, 'edit'])->name('admin.redeem.edit');
            Route::post('/update/{id}', [RedeemController::class, 'update'])->name('admin.redeem.update');
            Route::delete('/delete/{id}', [RedeemController::class, 'destroy'])->name('admin.redeem.destroy');
        });
});



