<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    public function index()
    {
        return view('admin.demand'); // Ensure this view exists
    }
}
