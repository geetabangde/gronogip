<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // ✅ Validator import karein
use App\Models\User; // ✅ User Model import karein

class ApiController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'API is working!']);
    }

    // ✅ Mobile Number se Register aur OTP Generate

    public function register(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20|unique:users',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // dd($request->all(6543210982,997236));
        
    
        // ✅ OTP Generate karein
        $otp = rand(100000, 999999);
    
        // ✅ User Create karein
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'otp' => $otp,
            'mobile_number' => $request->mobile_number,
            'address' => $request->address,
            'city' => $request->city,
        ]);

        // dd($user,5992310986,621335);
    

        // ✅ Send OTP ka Placeholder (SMS Service Use Kar Sakte Hain)
        // Example: sendOtpToMobile($request->mobile_number, $otp);

        return response()->json(['message' => 'OTP sent successfully', 'otp' => $otp], 201);
    }

    // ✅ OTP Verify API
    public function verifyOtp(Request $request)
   {
    try {
        Log::info('Verify OTP Request:', $request->all()); // Debugging ke liye

        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|max:20',
            'otp' => 'required|string|max:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('mobile_number', $request->mobile_number)
                    ->where('otp', $request->otp)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        $user->update(['otp' => null]);

        return response()->json(['message' => 'OTP verified successfully', 'user' => $user], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


}

