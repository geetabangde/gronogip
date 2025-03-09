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