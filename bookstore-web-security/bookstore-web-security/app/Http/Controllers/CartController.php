<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::all();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $cartItem = new Cart();
        $cartItem->book_id = $request->book_id;
        $cartItem->user_id = auth()->id();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Book added to cart!');
    }

    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Book removed from cart!');
    }
}