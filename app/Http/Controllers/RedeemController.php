<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedeemProduct;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class RedeemController extends Controller
{
    // ✅ Display all products
    public function index()
    {   
        $products = RedeemProduct::with('category')->get();
        $categories = Category::all();
        return view('admin.redeem.index', compact('products'));
    }

    // ✅ Show form to create a new product
    public function create()
    {
        $categories = Category::all();
        return view('admin.redeem.create', compact('categories'));
    }

    // ✅ Store a newly created product
    public function store(Request $request)
    {
        $request->validate([
            'redeem_product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'redeem_product_name' => 'required|string|max:255',
            'redeem_product_coins' => 'required|string|max:50',
            'redeem_product_description' => 'nullable|string',
            
        ]);

        $imagePath = null;
        if ($request->hasFile('redeem_product_image')) {
            $imagePath = $request->file('redeem_product_image')->store('products', 'public');
        }

        RedeemProduct::create([
            'redeem_product_image' => $imagePath,
            'redeem_product_name' => $request->redeem_product_name,
            'redeem_product_coins' => $request->redeem_product_coins,
            'redeem_product_description' => $request->redeem_product_description,
            
        ]);

        return redirect()->route('admin.redeem.index')->with('success', 'Redeem Product added successfully.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $product = RedeemProduct::findOrFail($id);
        $categories = Category::all();
        return view('admin.redeem.edit', compact('product'));
    }

    // ✅ Update product details
    public function update(Request $request, $id)
    {
        $request->validate([
            'redeem_product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'redeem_product_name' => 'required|string|max:255',
            'redeem_product_coins' => 'required|string|max:50',
            'redeem_product_description' => 'nullable|string',
           
        ]);

        $product = RedeemProduct::findOrFail($id);

        // ✅ Update product details
        $product->redeem_product_name = $request->redeem_product_name;
        $product->redeem_product_coins = $request->redeem_product_coins;
        $product->redeem_product_description = $request->redeem_product_description;
    

        // ✅ Handle image update
        if ($request->hasFile('redeem_product_image')) {
            if ($product->redeem_product_image) {
                Storage::disk('public')->delete($product->redeem_product_image);
            }
            $product->redeem_product_image = $request->file('redeem_product_image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('admin.redeem.index')->with('success', 'Redeem Product updated successfully.');
    }

    // ✅ Delete a product
    public function destroy($id)
    {
        $product = RedeemProduct::findOrFail($id);

        // ✅ Delete image from storage
        if ($product->redeem_product_image) {
            Storage::disk('public')->delete($product->redeem_product_image);
        }

        $product->delete();

        return response()->json(['success' => 'Redeem Product deleted successfully.']);
    }
}
