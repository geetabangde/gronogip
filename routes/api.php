<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController; 
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\OrderController;

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working!'], 200);
});

Route::post('register', [ApiController::class, 'register']); 
Route::post('verify-otp', [ApiController::class, 'verifyOtp']); 
Route::post('login', [ApiController::class, 'loginWithMobile']); 

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('profile', [ApiController::class, 'profile']);
    Route::post('update-profile', [ApiController::class, 'updateProfile']);

    // Manufacturers list  
    Route::get('manufacturers', [ManufacturerController::class, 'manufacturersList']); 

    // Brand routes
    Route::get('brands', [BrandController::class, 'index']); 
    Route::post('brands', [BrandController::class, 'store']);
    Route::get('brands/{id}', [BrandController::class, 'show']); 
    Route::put('brands/{id}', [BrandController::class, 'update']); 
    Route::delete('brands/{id}', [BrandController::class, 'destroy']); 

    // Product routes
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']); 
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::put('products/{id}', [ProductController::class, 'update']); 
    Route::delete('products/{id}', [ProductController::class, 'destroy']); 

    // Cart routes
    Route::post('cart/add', [CartController::class, 'addToCart']);
    Route::delete('cart/remove/{id}', [CartController::class, 'removeFromCart']);
    Route::get('cart/list', [CartController::class, 'cartList']);
    Route::put('/cart/update/{id}', [CartController::class, 'updateCart']);
    
    // Order routes
    Route::post('cart/checkout', [OrderController::class, 'checkout']);
    Route::get('orders', [OrderController::class, 'orderList']);
    Route::get('orders/{id}', [OrderController::class, 'show']);

});

