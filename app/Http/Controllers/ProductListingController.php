<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function index()
    {
        return view('admin.product_listing'); // Ensure this view exists
    }
}
