<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController; // ✅ Sahi Import

Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working!'], 200);
});

// ✅ Sahi tarika se APIController ka route likhein
Route::post('register', [ApiController::class, 'register']); // ✅ Mobile se Register
Route::post('verify-otp', [ApiController::class, 'verifyOtp']); // ✅ OTP Verify
Route::post('login', [ApiController::class, 'loginWithMobile']); // ✅ Mobile Se Login API

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('profile', [ApiController::class, 'profile']);
    
});

Route::get('/banners', [ApiController::class, 'getBanners']); // ✅ GET Banners API
Route::get('/categories', [ApiController::class, 'getCategories']);  // ✅ GET All Categories API
Route::get('/categories/{category_id}/subcategories', [ApiController::class, 'getSubcategoriesByCategory']); // ✅ GET Categories wise SUbCategories API
Route::get('/products', [ApiController::class, 'getFilteredProducts']); // ✅ GET All subcatogorywise product API
Route::get('/subcategory/{id}/products', [ApiController::class, 'getProductsBySubcategory']);


// products api for sell
Route::get('/getproducts', [ApiController::class, 'allProducts']); // Get all products
Route::post('/allproducts', [ApiController::class, 'store']); // Add a product
Route::post('/products/{id}', [ApiController::class, 'update']); // Update a product
Route::delete('/products/{id}', [ApiController::class, 'destroy']); // Delete a product

// products redeem api 
Route::get('/redeemproducts', [ApiController::class, 'allredeemproducts']); // Get all products
Route::post('/allredeemproducts', [ApiController::class, 'storeRedeem']); // Add a product
Route::post('/redeemproducts/{id}', [ApiController::class, 'updateredeemproducts']); // Update a product
Route::delete('/productsredeem/{id}', [ApiController::class, 'destroyredeem']); // Delete a product

Route::post('/redeem', [ApiController::class, 'redeemProduct']); // Redeem product
Route::post('/refer', [ApiController::class, 'referProduct']); // Refer product


// FeaturedProducts
Route::get('/featured-products', [ApiController::class, 'getFeaturedProducts']); // FeaturedProducts
Route::get('/products/{id}', [ApiController::class, 'show']); // Product details route
Route::get('/product-listing-data', [ApiController::class, 'getProductListingData']); // 1) GET subcategories + units
Route::post('/product-listings', [ApiController::class, 'storeProductListing']); // 2) POST store new product listing
Route::post('/demand-listings', [ApiController::class, 'storeDroductListing']); // DemandtListing from
Route::get('/freshdemand-listings', [ApiController::class, 'DemandListing']); // fresh DemandtListing 
Route::post('/refer', [ApiController::class, 'applyReferral']);