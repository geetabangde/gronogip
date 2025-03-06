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
        return view('admin.login'); // Ensure this view exists
    }

    

    public function login(Request $request)
    {
        // dd($request->all());
        // Validate request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check if admin exists, if not create a new one
        $admin = Admin::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => 'Default Admin', // You can change this to dynamic value
                'password' => Hash::make($request->password), // Hash password
            ]
        );
       
        // dd($admin);
        // dd(Auth::guard('admin'));
        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        //    dd(Auth::guard('admin'));
            return redirect()->route('admin.dashboard');
        }

            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        public function logout(Request $request)
        {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            return redirect()->route('admin.login');
        }
}
