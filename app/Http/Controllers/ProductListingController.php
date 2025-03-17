<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\ProductListing;

class ProductListingController extends Controller
{
    // ✅ Product Listing को Fetch करके View में भेजना
    public function index()
    {
        $products = ProductListing::with('subcategory')->get(); // ✅ Subcategory डेटा भी लाएँ
        return view('admin.product_listing', compact('products')); // ✅ View में भेजना
    }
}
