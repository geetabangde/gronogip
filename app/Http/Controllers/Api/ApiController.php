<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // ✅ Validator import karein
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use App\Models\User; 

class ApiController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'API is working!']);
    }

  // ✅ Routes
    public function register(Request $request)
   {   
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email'=>'required|string|email|max:255|unique:users',
        'mobile_number' => 'required|string|max:20|unique:users',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $otp = rand(100000, 999999);
    
    $user = User::where('mobile_number', $request->mobile_number)->first();
    
    if (!$user) {
        $user = User::create([
            'name' => $request->name,
            'you_are' => $request->you_are,
            'pan_number' => $request->pan_number,
            'firm_number' => $request->firm_number,
            'gst_number' => $request->gst_number,
            'adhar_number' => $request->adhar_number,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'industry' => $request->industry,
            'mobile_number' => $request->mobile_number,
            'otp' => $otp,
            'auth_token' => null
        ]);
    } else {
        $user->update(['otp' => $otp]);
    }

    return response()->json([
        'message' => 'OTP sent successfully',
        'otp' => $otp,
        'user' => $user
    ], 201);
   }



   // ✅ Verify OTP 
    public function verifyOtp(Request $request)
   {
        $request->validate([
            'mobile_number' => 'required',
            'otp' => 'required'
        ]);

        $user = User::where('mobile_number', $request->mobile_number)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if ($user->otp !== $request->otp) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // Always create a new token
        $token = $user->createToken('auth_token')->plainTextToken;

        // Save token in DB if you want to reuse later
        $user->update(['auth_token' => $token]);

        return response()->json([
            'message' => 'OTP verified successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    // ✅ Login with Mobile (Naya Token Generate Hoga)
    public function loginWithMobile(Request $request)
   {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('mobile_number', $request->mobile_number)->first();

        if ($user) {
            $otp = rand(100000, 999999);
            $user->update(['otp' => $otp]);

            return response()->json([
                'message' => 'OTP sent successfully',
                'otp' => $otp,
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Please register this account'
            ], 404);
        }
    }
    public function profile(Request $request){
        $user = $request->user();

        if($user){
            // Add full URL for profile image if exists
            if($user->profile_image){
                $user->profile_image = url($user->profile_image);
            }

            return response()->json([
                'message' => 'Profile Fetched',
                'data'=> $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not Authenticated'
            ], 401);
        }
    }
    // update profile
    public function updateProfile(Request $request)
    {
        // 🔍 Check if user is authenticated
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized user'
            ], 401);
        }

        // 📝 Fields that can be updated
        $updatableFields = [
            'name', 'email', 'mobile_number',
        ];

        foreach ($updatableFields as $field) {
            if ($request->has($field)) {
                $user->$field = $request->$field;
            }
        }

        // ✅ Handle profile image
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            // Save path in DB
            $user->profile_image = 'uploads/' . $filename;
        }

        $user->save();

        // Return full URL for image
        if ($user->profile_image) {
            $user->profile_image = url($user->profile_image);
        }

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ], 200);
    }

   

    public function logout(Request $request){
        $user = User::where('id',$request->user()->id)->first();
        if($user){
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Logged Out successfuly',
            ],200);
        }else{
            return response()->json([
                'message' => 'Use Not Found'
            ],404);
        }
    }
}




