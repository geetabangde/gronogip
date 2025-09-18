<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManufacturerController extends Controller
{
    // Manufacturer list API
    public function manufacturersList()
    {
        $manufacturers = Admin::where('role_id', 3)
            ->get(['id', 'name', 'email', 'address', 'created_at']); // select only necessary fields

        return response()->json([
            'success' => true,
            'data' => $manufacturers
        ]);
    }
}
