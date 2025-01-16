<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // public function index()
    // {
    //     $cartItems = Cart::where('user_id', Auth::id())->get();
    //     return view('cart.index', compact('cartItems'));
    // }

    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('variation.product')->get();
        return view('cart.index', compact('cartItems'));
    }


    // public function store(Request $request)
    // {
    //     $product = Product::findOrFail($request->product_id);
    //     Cart::create([
    //         'user_id' => Auth::id(),
    //         'product_id' => $product->id,
    //         'quantity' => $request->quantity
    //     ]);
    //     return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    // }
    public function store(Request $request)
    {
        $variation = Variation::findOrFail($request->variation_id);

        // Check stock availability
        if ($variation->stock < $request->quantity) {
            return redirect()->route('cart.index')->with('error', 'Not enough stock available.');
        }

        // Add to cart or update if it already exists
        $cart = Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'variation_id' => $variation->id,
            ],
            ['quantity' => 0]
        );

        $cart->update(['quantity' => $cart->quantity + $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Product variation added to cart!');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::with('variation')->findOrFail($id);

        // Check stock availability
        if ($cart->variation->stock < $request->quantity) {
            return redirect()->route('cart.index')->with('error', 'Not enough stock available.');
        }

        $cart->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    public function destroy($id)
    {
        Cart::destroy($id);
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    // public function update(Request $request, $id)
    // {
    //     $cart = Cart::findOrFail($id);
    //     $cart->update(['quantity' => $request->quantity]);
    //     return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    // }

    // public function destroy($id)
    // {
    //     Cart::destroy($id);
    //     return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    // }
}
