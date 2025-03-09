<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {   

        $users = User::all(); // ✅ Sare users fetch karein
        return view('admin.users', compact('users')); // ✅ View me bhejein
    }
}
