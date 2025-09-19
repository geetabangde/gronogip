<?php

namespace App\Http\Controllers;

use App\Models\User; 

use Illuminate\Http\Request;

class ManufacturerDashboardController extends Controller
{
    public function index()
    { 
        $userCount = User::count(); // Get total users  
        return view('manufacturer.dashboard', compact('userCount'));  // Pass the user count to the view); 
    }
}
