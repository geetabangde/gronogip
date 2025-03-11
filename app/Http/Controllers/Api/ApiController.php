<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; // ✅ Validator import karein
use Illuminate\Support\Facades\Session;
use App\Models\User; // ✅ User Model import karein
use App\Models\Banner; // ✅ Banner Model import karein
use App\Models\Category; // ✅ Category Model import karein
use App\Models\Subcategory;  // ✅ SubCategory Model import karein
use App\Models\Product; // ✅ Product Model import karein
use App\Models\ProductSell; // ✅ Product Model import karein
use App\Models\ProductListing; // ✅ ProductListing Model import karein
use App\Models\DemandListing; // ✅ DemandListing Model import karein

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
        // Check if subcategory has products
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

        // If no products found, return empty array
        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No products found for this subcategory.',
                'subcategory_id' => $id,
                'products' => []
            ], 404);
        }

        // If products found, return response
        return response()->json([
            'status' => true,
            'subcategory_id' => $id,
            'products' => $products,
        ]);
    }

    // product for sell

   // ✅ 1. Get All Products
   
       // Get all products
       public function allProducts()
       {
           $productsell = ProductSell::all();
           
           return response()->json(['status' => true, 'products' => $productsell]);
       }
   
       // Add a new product
       public function store(Request $request)
       {
      
           $request->validate([
               'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
               'product_name' => 'required|string|max:255',
               'price' => 'required|string|max:50',
               
           ]);
       
           $imagePath = null;
           if ($request->hasFile('image')) {
               $imagePath = $request->file('image')->store('products', 'public');
           }
       
           // ✅ Ensure quantity is optional but default to 1 if not provided
           $quantity = $request->has('quantity') ? $request->quantity : 1;
       
           // ✅ Store product in database
           $product = ProductSell::create([
               'image' => $imagePath,
               'product_name' => $request->product_name,
               'quantity' => $quantity, // ✅ Ensure quantity is set
               'price' => $request->price,
               'description' => $request->description,
           ]);
       
           // ✅ Return JSON Response
           return response()->json([
               'status' => true,
               'message' => 'Product added successfully',
               'product' => $product
           ], 201);
       }
       
   
       // Update a product
    public function update(Request $request,$id)
    {
    // dd($request->all());
    try {
        // Find the product by ID
        $productsell = ProductSell::find($id);
        if (!$productsell) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        // Debugging: Log request data
        \Log::info('Update Request Data:', $request->all());

        // Validate request data
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer|min:1',
            'price' => 'sometimes|string|max:50',
            'description' => 'nullable|string',
        ]);

        // Handle Image Upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $productsell->image = $imagePath;
        }

        // Update fields only if they are provided
        if ($request->filled('product_name')) {
            $productsell->product_name = $request->product_name;
        }
        if ($request->filled('quantity')) {
            $productsell->quantity = $request->quantity;
        }
        if ($request->filled('price')) {
            $productsell->price = $request->price;
        }
        if ($request->filled('description')) {
            $productsell->description = $request->description;
        }

        // Save updated data
        $productsell->save();

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'product' => $productsell
        ]);
    } catch (\Exception $e) {
        \Log::error('Update Error: '.$e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
    }

//   delete product
    public function destroy($id)
    {
        Log::info("Delete request received for product ID: " . $id);

        $productsell = ProductSell::find($id);
        if (!$productsell) {
            Log::error("Product with ID $id not found!");
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        $productsell->delete();
        Log::info("Product deleted successfully.");

        return response()->json(['status' => true, 'message' => 'Product deleted successfully']);
    }

    public function getFeaturedProducts()
    {
        $featuredProducts = ProductSell::where('is_featured', 1)->get();

        return response()->json([
            'status' => true,
            'message' => 'Featured products fetched successfully',
            'products' => $featuredProducts
        ], 200);
    }
    
    public function show($id)
   {
    // Find product by ID
    $product = ProductSell::find($id);

    // If not found, return error
    if (!$product) {
        return response()->json([
            'status' => false,
            'message' => 'Product not found'
        ], 404);
    }

    // Return product details
    return response()->json([
        'status' => true,
        'message' => 'Product details fetched successfully',
        'product' => $product
    ], 200);

   }

   
       public function getProductListingData()
       {
           // 1) Fetch subcategories (id, name)
           $subcategories = Subcategory::all(['id', 'name']);
   
           // 2) Static units
           $units = ['Kilogram', 'Quintal', 'Ton', 'Gram'];
   
           return response()->json([
               'status' => true,
               'message' => 'Product listing data fetched successfully',
               'subcategories' => $subcategories,
               'units' => $units
           ], 200);
       }
   
       /**
        * 2. POST /product-listings
        *    Stores a new product listing in the "product_listings" table.
        */
        public function storeProductListing(Request $request)
      {
        Log::info('Incoming product listing data:', $request->all());

        $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'quantity'       => 'required|integer|min:1',
            'selling_rate'   => 'required|string|max:50',
            'per_unit'       => 'required|string|max:50',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        
           $imagePath = null;
           if ($request->hasFile('image')) {
               $imagePath = $request->file('image')->store('products', 'public');
               Log::info("Image stored at: $imagePath");Log::info("Image stored at: $imagePath");
               Log::info("Image stored at: $imagePath");
           }

        $listing = ProductListing::create([
            'subcategory_id' => $request->subcategory_id,
            'quantity'       => $request->quantity,
            'selling_rate'   => $request->selling_rate,
            'per_unit'       => $request->per_unit,
            'image'          => $imagePath,
        ]);

        Log::info("Product listing created: ID {$listing->id}");

        return response()->json([
            'status'  => true,
            'message' => 'Product listing created successfully',
            'data'    => $listing
        ], 201);
      }

     

   /**
     * Store a new demand listing.
     */
   


     public function storeDroductListing(Request $request)
    {   
        // dd($request->all());
        Log::info('Incoming demand listing data:', $request->all());

        // Validate required fields
        $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'user_id'        => 'required|exists:users,id',
            'quantity'       => 'required|integer|min:1',
            'delivary_date'  => 'nullable|date',
            'notes'          => 'nullable|string',
            'selling_rate'   => 'nullable|string|max:50',
            'per_unit'       => 'nullable|string|max:50',
            'unit'           => 'nullable|string|max:50',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 1) Find the user (to get mobile_number & city)
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 404);
        }

        // 2) Handle image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('demand_images', 'public');
            Log::info("Demand listing image stored at: $imagePath");
        }

        // 3) Create the demand listing
        $demand = DemandListing::create([
            'subcategory_id'  => $request->subcategory_id,
            'user_id'         => $request->user_id,
            'quantity'        => $request->quantity,
            'delivary_date'   => $request->delivary_date,
            'notes'           => $request->notes,
            'selling_rate'    => $request->selling_rate,
            'per_unit'        => $request->per_unit,
            'unit'            => $request->unit,
            'image'           => $imagePath,

            // 4) Auto-fill from user table
            'contact_details' => $user->mobile_number, // e.g. from "mobile_number" column
            'location'        => $user->city,          // e.g. from "city" column
        ]);

        Log::info("Demand listing created: ID {$demand->id}");

        return response()->json([
            'status'  => true,
            'message' => 'Demand listing created successfully',
            'data'    => $demand
        ], 201);
    }

    
    
    /**
     * Show all demand listings in a feed.
     */
    public function DemandListing()
    {
        // 1) Fetch all demands, eager-load subcategory & user
        //    so we can display subcategory name & user city, etc.
        $demands = DemandListing::with(['subcategory', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 2) Transform each demand item to the shape you need
        //    e.g., commodity, target price, location, time_ago, etc.
        $data = $demands->map(function ($demand) {
            return [
                'id'           => $demand->id,
                'commodity'    => optional($demand->subcategory)->name, // subcategory name
                'target_price' => $demand->selling_rate,                // e.g. "150"
                'quantity'     => $demand->quantity,                    // e.g. 20
                'location'     => optional($demand->user)->city,        // from user table
                'time_ago'     => $demand->created_at->diffForHumans(), // e.g. "3 hours ago"
                // Add more fields if needed (delivery_date, contact_details, etc.)
            ];
        });

        // 3) Return as JSON
        return response()->json([
            'status'  => true,
            'message' => 'Demand listings fetched successfully',
            'data'    => $data
        ], 200);
    }




    }
   








