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
        $cartItems = Cart::where('user_id', Auth::id())->with('product', 'manufacturer')->get();

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

        // Create order items safely
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'manufacturer_id' => $item->manufacturer_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->product->price * $item->quantity,
                'manufacturer_address' => optional($item->manufacturer)->address,
            ]);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        // Prepare response with user_id
        $orderItems = $order->items()->with('product', 'manufacturer')->get()->map(function ($item) use ($order) {
            return [
                'id' => $item->id,
                'order_id' => $item->order_id,
                'user_id' => $order->user_id,
                'product_id' => $item->product_id,
                'manufacturer_id' => $item->manufacturer_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->subtotal,
                'manufacturer_address' => $item->manufacturer_address,
                'product' => $item->product,
                'manufacturer' => $item->manufacturer,
            ];
        });

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'payment_status' => $order->payment_status,
                'payment_method' => $order->payment_method,
                'address' => $order->address,
                'items' => $orderItems,
            ]
        ], 201);
    }


    // List all orders of authenticated user
    public function orderList()
    {
        // $orders = Order::where('user_id', Auth::id())->with('items.product')->latest()->get();
        $orders = Order::where('user_id', Auth::id())
    ->with('items.product', 'items.manufacturer')
    ->latest()->get();


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
