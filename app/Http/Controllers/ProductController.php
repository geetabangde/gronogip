<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display all products
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // Show form to create a new product
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // Store a newly created product
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            // 'category_id' => 'required|exists:categories,id',
            'price' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'image' => $imagePath,
            'name' => $request->name,
            // 'category_id' => $request->category_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product added successfully.');
    }

    // Show edit form
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Update product details
    public function update(Request $request, $id)
   {
    $request->validate([
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name' => 'required|string|max:255',
        'price' => 'required|string|max:50',
        'description' => 'nullable|string',
    ]);

    $product = Product::find($id);

    if (!$product) {
        return redirect()->route('admin.products.index')->with('error', 'Product not found.');
    }

    // Update fields
    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;

    // Handle image upload
    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->image = $request->file('image')->store('products', 'public');
    }

    $product->save(); // ✅ Save changes

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
   }


   

    // Delete a product
    

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }

        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
