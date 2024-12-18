<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity
        ]);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function destroy($id)
    {
        Cart::destroy($id);
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
