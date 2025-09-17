<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // List all products for the authenticated user
    public function index()
   {
    $products = Product::where('user_id', Auth::id())->get();

    // add full image path
    $products = $products->map(function ($product) {
        if ($product->image) {
            $product->image = url('uploads/' . basename($product->image));
        }
        return $product;
    });

    return response()->json([
        'message' => 'Product List',
        'data' => $products
    ], 200);

   }


    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'brand_id' => 'required|integer|exists:brands,id',
        ]);

        $imageName = null;

        
        // Image upload logic
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $imageName = 'image_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);

            // full URL path
            $imageUrl = url('uploads/' . $imageName);
        }

        $product = Product::create([
            'name' => $request->name,
            'image' => $imageUrl, // full path saved here
            'quantity' => $request->quantity,
            'price' => $request->price,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'user_id' => Auth::id(),
            'status' => $request->status ?? 'active', // default if status not sent
        ]);

        return response()->json($product, 201);
    }


    // Show a single product
    public function show($id)
   {
        $product = Product::where('user_id', Auth::id())
            ->findOrFail($id);

        // add full image path
        if ($product->image) {
            $product->image = url('uploads/' . basename($product->image));
        }

        return response()->json([
            'message' => 'Product Details',
            'data' => $product
        ], 200);
   }


    // Update a product
    public function update(Request $request, $id)
   {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'quantity' => 'sometimes|required|integer',
            'price' => 'sometimes|required|numeric',
            'description' => 'nullable|string',
            'brand_id' => 'sometimes|required|integer|exists:brands,id',
            
        ]);

        // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $imageName = 'image_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);

            // full URL
            $product->image = url('uploads/' . $imageName);
        }

        // Update other fields
        $product->fill($request->except('image'));
        $product->save();

        // Ensure image full path in response
        if ($product->image) {
            $product->image = url('uploads/' . basename($product->image));
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }
    
    // Delete a product
    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete image if exists
        if ($product->image) {
            $imagePath = public_path('uploads/' . basename($product->image));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ], 200);
    }

}
