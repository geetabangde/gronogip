<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    
    public function listOrders()
{
    $manufacturerId = Auth::id(); // Manufacturer ID

    $orders = Order::whereHas('items', function($query) use ($manufacturerId) {
        $query->where('manufacturer_id', $manufacturerId);
    })
    ->with(['items' => function($query) use ($manufacturerId) {
        $query->where('manufacturer_id', $manufacturerId)->with('product');
    }, 'user']) // Eager load user for retailer name
    ->latest()
    ->get();

    return view('manufacturer.orders.list', compact('orders'));
}

    // Show single order
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())->with('items.product')->findOrFail($id);

        return response()->json([
            'message' => 'Order details fetched successfully',
            'data' => $order
        ], 200);
    }
}
