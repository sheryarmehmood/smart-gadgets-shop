<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        dd($orders);
        // return view('orders.index', compact('orders'));
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price
            ]);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    public function payment()
    {
        return view('payment.index');
    }

    public function processPayment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:credit_card,paypal,cash_on_delivery',
        ]);
    
        // Simulating order creation
        $orderId = uniqid('ORDER_');
        $totalAmount = 100.00; // Example: Replace with actual calculation
    
        // Set session data for confirmation
        session([
            'customer_name' => $validatedData['name'],
            'customer_email' => $validatedData['email'],
            'order_id' => $orderId,
            'payment_method' => $validatedData['payment_method'],
            'total_amount' => $totalAmount,
        ]);
    
        // Redirect to confirmation page
        return redirect()->route('orders.confirmation');
    }
    

     public function confirmation()
    {
        return view('orders.confirmation', [
            'customer_name' => session('customer_name', 'Customer'),
            'customer_email' => session('customer_email', 'example@example.com'),
            'order_id' => session('order_id', 'N/A'),
            'payment_method' => session('payment_method', 'N/A'),
            'total_amount' => session('total_amount', '0.00'),
        ]);
    }
    
}
