<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {   
        $userCount = User::count(); // Get total users
        return view('admin.dashboard', compact('userCount'));
    }
    // listBrands
    public function listBrands()
   {
    $brands = Brand::with('manufacturer')->get();
    return view('admin.brands.list', compact('brands'));
   }

    //    History
    public function History()
    {
        // Fetch all payments with QR info
        $payments = DB::table('qr_payments')
            ->join('q_r_codes', 'qr_payments.qr_code_id', '=', 'q_r_codes.id')
            ->select(
                'qr_payments.*',
                'q_r_codes.razorpay_qr_id',
                'q_r_codes.description',
                 'q_r_codes.image_url'
            )
            ->orderBy('qr_payments.paid_at', 'desc')
            ->get();

            

        return view('admin.history.list', compact('payments'));
    }

   //    order list
    public function listOrders()
   {
        $authUser = Auth::user();

        if ($authUser->role_id == 1) {  
            // ✅ Admin => sabhi orders dikhayega
            $orders = Order::with([
                'items.product',
                'items.manufacturer',
                'user'
            ])->latest()->get();

            return view('admin.orders.list', compact('orders'));
        }

        if ($authUser->role_id == 3) {  
            // ✅ Manufacturer => sirf apne orders
            $manufacturerId = $authUser->id;

            $orders = Order::whereHas('items', function($query) use ($manufacturerId) {
                    $query->where('manufacturer_id', $manufacturerId);
                })
                ->with(['items' => function($query) use ($manufacturerId) {
                    $query->where('manufacturer_id', $manufacturerId)->with('product');
                }, 'user'])
                ->latest()
                ->get();

            return view('manufacturer.orders.list', compact('orders'));
        }

        abort(403, 'Unauthorized'); // Agar retailer ya koi aur role ho
    }



//    admin.product.list

    public function listProducts()
    {
        $products = Product::all();
        $products = $products->map(function ($product) {
            if ($product->image) {
                $product->image = url('uploads/' . basename($product->image));
            }
            return $product;
        });
        return view('admin.products.list', compact('products'));
    }


    // Show create manufacturer form
    public function createManufacturer()
    {
        return view('admin.manufacturers.create'); 
    }
    // edit manufacturer form
    public function editManufacturer($id){
        $manufacturer = Admin::find($id);
        if (!$manufacturer) {
            return redirect()->route('admin.manufacturers.list')->with('error', 'Manufacturer not found');
        }
        return view('admin.manufacturers.edit', compact('manufacturer'));
    }
    // Update a manufacturer
    public function updateManufacturer(Request $request, $id)
    {
        
        $manufacturer = Admin::find($id);   
        
        // Update manufacturer
        $manufacturer->name = $request->name;
        $manufacturer->email = $request->email;
        $manufacturer->address = $request->address;
        
        $manufacturer->save();
        return redirect()->route('admin.manufacturers.list')->with('success', 'Manufacturer updated successfully.');
    }

    // Store manufacturer
    public function storeManufacturer(Request $request)
    {
    
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required', 
        ]);

        // Create manufacturer and capture the created model
        $manufacturer = Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'address'  => $request->address, 
            'role_id'  => 3, 
        ]);

        // Dump the created model to check
        // dd($manufacturer);
        
        return redirect()->route('admin.manufacturers.list')->with('success', 'Manufacturer created successfully.');
        
    }
    // List all manufacturers
    public function listManufacturers()
    {
        $manufacturers = Admin::where('role_id', 3)->get(); // role_id = 3 for manufacturers
        return view('admin.manufacturers.list', compact('manufacturers'));
    }

    // delete manufacturer

    public function deleteManufacturer($id){
        $manufacturer = Admin::find($id);
        if($manufacturer){
            $manufacturer->delete();
            return redirect()->route('admin.manufacturers.list')->with('success', 'Manufacturer deleted successfully.');
        }
        return redirect()->route('admin.manufacturers.list')->with('error', 'Manufacturer not found.');
    }

}
