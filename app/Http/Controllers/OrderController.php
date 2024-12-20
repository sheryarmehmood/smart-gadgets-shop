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

    // public function payment()
    // {
    //     return view('payment.index');
    // }

    
    public function payment()
    {
    $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

    $totalPrice = $cartItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    return view('payment.index', compact('cartItems', 'totalPrice'));
    }


    // public function processPayment(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'phone' => 'required|string|max:15',
    //         'address' => 'required|string',
    //         'payment_method' => 'required|string|in:credit_card,paypal,cash_on_delivery',
    //     ]);
    
    //     // Simulating order creation
    //     $orderId = uniqid('ORDER_');
    //     $totalAmount = 100.00; // Example: Replace with actual calculation
    
    //     // Set session data for confirmation
    //     session([
    //         'customer_name' => $validatedData['name'],
    //         'customer_email' => $validatedData['email'],
    //         'order_id' => $orderId,
    //         'payment_method' => $validatedData['payment_method'],
    //         'total_amount' => $totalAmount,
    //     ]);
    
    //     // Redirect to confirmation page
    //     return redirect()->route('orders.confirmation');
    // }
    
    public function processPayment(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:credit_card,paypal,cash_on_delivery',
        ]);
    
        // Fetch cart items and calculate total
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
    
        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_price' => $totalAmount,
            'status' => 'pending',
        ]);
    
        // Save order items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }
    
        // Clear the cart
        Cart::where('user_id', Auth::id())->delete();
    
        // Set session data
        session([
            'customer_name' => $validatedData['name'],
            'customer_email' => $validatedData['email'],
            'order_id' => $order->id, // Use the actual order ID
            'payment_method' => $validatedData['payment_method'],
            'total_amount' => $totalAmount,
        ]);
    
        return redirect()->route('orders.confirmation');
    }


    


    //  public function confirmation()
    // {
    //     return view('orders.confirmation', [
    //         'customer_name' => session('customer_name', 'Customer'),
    //         'customer_email' => session('customer_email', 'example@example.com'),
    //         'order_id' => session('order_id', 'N/A'),
    //         'payment_method' => session('payment_method', 'N/A'),
    //         'total_amount' => session('total_amount', '0.00'),
    //     ]);
    // }


    public function confirmation()
    {
        $orderId = session('order_id');
    
        // Redirect if no order ID is found in the session
        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'No order found.');
        }
    
        // Fetch the order and its related items
        $order = Order::with('items.product')->find($orderId);
    
        // Redirect if the order is not found
        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found in the database.');
        }
    
        // Pass data to the view
        return view('orders.confirmation', [
            'order' => $order,
            'customer_name' => session('customer_name', 'Customer'),
            'customer_email' => session('customer_email', 'example@example.com'),
            'payment_method' => session('payment_method', 'N/A'),
            'total_amount' => $order->total_price,
        ]);
    }
    

    // public function confirmation()
    // {
    //     $orderId = session('order_id');

    //     // Check if the order_id exists in the session
    //     if (!$orderId) {
    //         return redirect()->route('cart.index')->with('error', 'No order found.');
    //     }

    //     // Fetch the order and its related items and products
    //     $order = Order::with('items.product')->where('id', $orderId)->first();

    //     // If the order is not found in the database
    //     if (!$order) {
    //         return redirect()->route('cart.index')->with('error', 'Order not found in the database.');
    //     }

    //     // Pass data to the view
    //     return view('orders.confirmation', [
    //         'order' => $order,
    //         'customer_name' => session('customer_name', 'Customer'),
    //         'customer_email' => session('customer_email', 'example@example.com'),
    //         'payment_method' => session('payment_method', 'N/A'),
    //         'total_amount' => $order->total_price,
    //     ]);
    // }

    
}
