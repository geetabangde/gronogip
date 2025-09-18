<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // ✅ Ensure this line is present



class LoginController extends Controller
{

    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
   {
        // Validate request data
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
          // Find user by email first
         $user = Admin::where('email', $request->email)->first();

        //     if($user) {
        //     dd([
        //         'user' => $user,
        //         'password_input' => $request->password,
        //         'check_password' => Hash::check($request->password, $user->password),
        //     ]);
        // } else {
        //     dd('No user found with this email');
        // }

        // Attempt login using admin guard (covers all roles)
            if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
                $user = Auth::guard('admin')->user();
                // Hashing password for security reasons

                // Role-based redirect
                switch ($user->role_id) {
                    case 1:
                        return redirect()->route('admin.dashboard');
                    case 2:
                        return redirect()->route('retailer.dashboard');
                    case 3:
                        return redirect()->route('manufacturer.dashboard');
                    default:
                        Auth::guard('admin')->logout();
                        return back()->withErrors(['email' => 'Unauthorized role.']);
                }
            }

        // Login failed
        return back()->withErrors(['email' => 'Invalid credentials.']);
   }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.login');
    }
}
