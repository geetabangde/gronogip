<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add to Cart
    public function addToCart(Request $request)
   {
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'nullable|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);

    // Requested quantity
    $requestedQty = $request->quantity ?? 1;

    // Check stock availability
    if ($product->quantity < $requestedQty) {
        return response()->json([
            'message' => 'Only ' . $product->quantity . ' Quantity available in product',
        ], 400);
    }

    // Update or create cart
    $cart = Cart::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ],
        [
            'quantity' => $requestedQty,
        ]
    );

    // Decrease stock from product table
    $product->decrement('quantity', $requestedQty);

    return response()->json([
        'message' => 'Product added to cart successfully',
        'data' => $cart->load('product')
    ], 201);
   }
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        $product = $cart->product;

        $oldQty = $cart->quantity;
        $newQty = $request->quantity;

        // Difference nikalte hain
        $difference = $newQty - $oldQty;

        if ($difference > 0) {
            // Agar nayi qty zyada hai, to check karna padega stock me hai ya nahi
            if ($product->quantity < $difference) {
                return response()->json([
                    'message' => 'Only ' . $product->quantity . ' units available in stock',
                ], 400);
            }

            // Stock se minus karo
            $product->decrement('quantity', $difference);
        } elseif ($difference < 0) {
            // Agar nayi qty kam hai, to stock wapas add karo
            $product->increment('quantity', abs($difference));
        }

        // Update cart
        $cart->update([
            'quantity' => $newQty,
        ]);

        return response()->json([
            'message' => 'Cart updated successfully',
            'data' => $cart->load('product')
        ]);
   }


    // Remove from Cart
    public function removeFromCart($id)
    {
    
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();
        $cart->delete();

        return response()->json(['message' => 'Product removed from cart successfully'], 200);
    }

    // Cart List
    public function cartList()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        return response()->json([
            'message' => 'Cart items fetched successfully',
            'data' => $cartItems
        ], 200);
    }
}
