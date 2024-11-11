<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function addToCart(Request $request )
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        $existingCartItem = Cart::where('user_id', 1)
            ->where('product_id', $request->product_id)
            ->first();
        if ($existingCartItem) {
            return response()->json(['message' => 'Product already in cart'], 200);
        }
        $cartItem = Cart::create([
            'product_id' => $request->product_id,
            'user_id' => 1,  
            'quantity' => $request->quantity
        ]);
        return response()->json(['message' => 'Product added to cart successfully', 'cart_item' => $cartItem]);
    }

    public function cartItems()
    {
        $cartItems = Cart::with('product.images')->where('user_id', 1)->get();
        return response()->json($cartItems);
    }

    public function viewCart()
    {
        $cartItems = Cart::with('product.images')->where('user_id', 1)->get();
        return view('cart.view', compact('cartItems'));
    }
    public function removeFromCart($productId)
    {

        $cartItem = Cart::find($productId);

        if ($cartItem) {
            $cartItem->delete();  
            return response()->json(['success' => true], 200);
        }
        return response()->json(['message' => 'Product removed from cart'], 200);
    }
    public function updateQuantity(Request $request, $cartId)
    {
        $cartItem = Cart::find($cartId);

        if ($cartItem) {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 404);
    }
}
