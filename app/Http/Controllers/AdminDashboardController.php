<?php

namespace App\Http\Controllers;

use App\Models\User; 

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {   
        $userCount = User::count(); // Get total users
        return view('admin.dashboard', compact('userCount'));
    }

}
