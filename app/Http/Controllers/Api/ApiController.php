<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // ✅ Validator import karein
use App\Models\User; // ✅ User Model import karein
use App\Models\Banner; // ✅ Banner Model import karein
use App\Models\Category; // ✅ Category Model import karein
use App\Models\Subcategory;  // ✅ SubCategory Model import karein
use App\Models\Product; // ✅ Product Model import karein

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
           
            'mobile_number' => 'required|string|max:20|unique:users',
            
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

   // ✅ Mobile Number Se Login API
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
           return response()->json([
               'message' => 'Login successful',
               'user' => $user
           ], 200);
       } else {
           return response()->json([
               'message' => 'Please register this account'
           ], 404);
       }
   }

   // ✅ Banner Api 

   public function getBanners(Request $request)
   {
    $banners = Banner::all()->map(function ($banner) {
        $banner->image = url('storage/' . $banner->image); // ✅ Full URL generate karein
        return $banner;
    });

    return response()->json([
        'message' => 'All banners retrieved successfully!',
        'banners' => $banners
    ], 200);
   }

   // ✅ All Categories Api 
   public function getCategories(Request $request)
    {
        $categories = Category::all();
        return response()->json([
            'message' => 'All categories retrieved successfully!',
            'categories' => $categories
        ], 200);
    }

    // ✅Categories Wise  All SubCategories Api 
    public function getSubcategoriesByCategory($category_id)
   {
    // ✅ Given category_id ke subcategories fetch karein
    $subcategories = Subcategory::where('category_id', $category_id)->get();

    // ✅ Image ka full URL generate karein
    $subcategories->transform(function ($subcategory) {
        $subcategory->image = $subcategory->image ? url('storage/' . $subcategory->image) : null;
        return $subcategory;
    });

    // ✅ Agar subcategories milti hain to response bhejein
    if ($subcategories->isEmpty()) {
        return response()->json(['message' => 'No subcategories found for this category'], 404);
    }

    return response()->json([
        'message' => 'Subcategories retrieved successfully!',
        'subcategories' => $subcategories
    ], 200);
   
   }

  

    // ✅ Agar city wise filter milti hain to response bhejein
    public function getFilteredProducts(Request $request)
    {
        // ✅ City wise filter (Agar city di ho)
        $query = Product::query();

        if ($request->has('city')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        // ✅ Subcategory wise filter
        if ($request->has('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        // ✅ Fetching data
        $products = $query->with(['subcategory', 'user'])->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'subcategory_name' => optional($product->subcategory)->name,
                'subcategory_image' => optional($product->subcategory)->image ? url('storage/' . $product->subcategory->image) : null,
                'user_id' => $product->user_id,
                'user_name' => optional($product->user)->name,
                'city' => optional($product->user)->city,
                'price' => $product->price, // ✅ Product Price
                'quantity' => $product->quantity, // ✅ Product Quantity
                'description' => $product->description, // ✅ Product Description
                'product_image' => $product->image ? url('storage/' . $product->image) : null, // ✅ Product Image
            ];
        });

        return response()->json([
            'message' => 'Filtered products retrieved successfully!',
            'products' => $products
        ], 200);
    }

    // ✅ Agar city wise product details
    public function getProductsBySubcategory($id)
    {
        $products = Product::where('subcategory_id', $id)
            ->with(['subcategory', 'user'])
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'subcategory_name' => optional($product->subcategory)->name,
                    'subcategory_image' => optional($product->subcategory)->image ? url('storage/' . $product->subcategory->image) : null,
                    'user_name' => optional($product->user)->name,
                    'city' => optional($product->user)->city,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'description' => $product->description,
                    'product_image' => $product->image ? url('storage/' . $product->image) : null,
                ];
            });

        return response()->json([
            'status' => true,
            'subcategory_id' => $id,
            'products' => $products,
        ]);
    }

}



