<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemandListingController extends Controller
{
    public function index()
    {
        return view('admin.demand_listing'); // Ensure this view exists
    }
}
