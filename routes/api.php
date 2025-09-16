<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController; 
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CartController;

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

    // Brand routes
    Route::get('brands', [BrandController::class, 'index']); // list all brands
    Route::post('brands', [BrandController::class, 'store']); // add brand
    Route::get('brands/{id}', [BrandController::class, 'show']); // single brand
    Route::put('brands/{id}', [BrandController::class, 'update']); // update brand
    Route::delete('brands/{id}', [BrandController::class, 'destroy']); // delete brand

    // Product routes
    Route::get('products', [ProductController::class, 'index']); // list all products
    Route::post('products', [ProductController::class, 'store']); // add product
    Route::get('products/{id}', [ProductController::class, 'show']); // single product
    Route::put('products/{id}', [ProductController::class, 'update']); // update product
    Route::delete('products/{id}', [ProductController::class, 'destroy']); // delete product

    // Cart routes
    Route::post('cart/add', [CartController::class, 'addToCart']);
    Route::delete('cart/remove/{id}', [CartController::class, 'removeFromCart']);
    Route::get('cart/list', [CartController::class, 'cartList']);
    Route::put('/cart/update/{id}', [CartController::class, 'updateCart']);

});

