<?php
namespace App\Http\Controllers\Backend;
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
        
        $products = Product::all();
        $products = $products->map(function ($product) {
            if ($product->image) {
                $product->image = url('uploads/' . basename($product->image));
            }
            return $product;
        });
        return view('manufacturer.products.index', compact('products'));
    }
   

    public function create(){
        $brands = Brand::all();
        return view('manufacturer.products.create',compact('brands'));
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
        // Image upload logic
        $imageUrl = null;

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
            'image' => $imageUrl, // now safe
            'quantity' => $request->quantity,
            'price' => $request->price,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'status' => $request->status ?? 1, // default 1 = active
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully.');
    }


    public function edit($id)
    {
        $product = Product::find($id);
        $brands = Brand::all();
        if (!$product) {
            return redirect()->route('admin.product.index')->with('error', 'Product not found');
        }
        return view('manufacturer.products.edit', compact('product','brands'));
    }

    // Update a product
    public function update(Request $request, $id)
   {
    // Fetch the product by ID (no user_id check)
    $product = Product::findOrFail($id);

    // Validation
    $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'quantity' => 'sometimes|required|integer',
        'price' => 'sometimes|required|numeric',
        'description' => 'nullable|string',
        'brand_id' => 'sometimes|required|integer|exists:brands,id',
        'status' => 'nullable|in:0,1',
    ]);

    // Handle image upload
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $file = $request->file('image');
        $imageName = 'image_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $imageName);

        // Update image URL
        $product->image = url('uploads/' . $imageName);
    }

    // Update other fields except image
    $product->update($request->except('image'));

    return redirect()->route('admin.product.index')->with('success', 'Product updated successfully.');
    }


    // Delete a product
    public function destroy($id)
   {
        // Fetch product by ID (no user_id check)
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->image) {
            $imagePath = public_path('uploads/' . basename($product->image));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete product
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
    }

}
