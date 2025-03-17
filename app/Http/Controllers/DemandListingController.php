<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\DemandListing;
use App\Models\User;

class DemandListingController extends Controller
{
    public function index()
    {    
        $products = DemandListing::with(['subcategory', 'user'])->get();   // ✅ Subcategory डेटा भी लाएँ
        return view('admin.demand_listing', compact('products')); // Ensure this view exists
    }
}
