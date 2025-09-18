<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Checkout / Place Order
    public function checkout(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $request->payment_method ?? 'COD',
            'address' => $request->address ?? 'Default Address',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->product->price * $item->quantity,
            ]);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order->load('items.product'),
        ], 201);
    }

    // List all orders of authenticated user
    public function orderList()
    {
        $orders = Order::where('user_id', Auth::id())->with('items.product')->latest()->get();

        return response()->json([
            'message' => 'Orders fetched successfully',
            'data' => $orders
        ], 200);
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
