<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        // dd($orders);
        // return view('orders.index', compact('orders'));
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
    $order = Order::with('items.variation.product')
        ->where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();
    // dd($order);
    return view('orders.show', compact('order'));
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
    $cartItems = Cart::where('user_id', Auth::id())->with('variation.product')->get();
    // dd($cartItems);
    $totalPrice = $cartItems->sum(function ($item) {
        return $item->variation->price * $item->quantity;
    });

    return view('payment.index', compact('cartItems', 'totalPrice'));
    }



    // public function processPayment(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'address' => 'required|string',
    //         'payment_method_id' => 'required|string',
    //     ]);
    
      
    

    //     // Fetch cart items and calculate total
    //     $cartItems = Cart::where('user_id', Auth::id())->get();
    //     $totalAmount = $cartItems->sum(function ($item) {
    //         return $item->product->price * $item->quantity;
    //     });
    

    //     try {
    //         // Set Stripe API key
    //         Stripe::setApiKey(env('STRIPE_SECRET'));
    
    //         // Create a PaymentIntent
    //         $paymentIntent = PaymentIntent::create([
    //             'amount' => $totalAmount * 100, // Amount in cents
    //             'currency' => 'usd',
    //             'payment_method' => $request->payment_method_id,
    //             'confirmation_method' => 'manual',
    //             'confirm' => true,
    //             'return_url' => route('orders.confirmation'), // Add the return URL
    //         ]);
    
    //         if ($paymentIntent->status === 'succeeded') {
    //             // Process the successful payment (e.g., save order details)
    //             $order = Order::create([
    //                 'user_id' => Auth::id(),
    //                 'total_price' => $totalAmount,
    //                 'status' => 'paid',
    //             ]);
    
    //             foreach ($cartItems as $cartItem) {
    //                 OrderItem::create([
    //                     'order_id' => $order->id,
    //                     'product_id' => $cartItem->product_id,
    //                     'quantity' => $cartItem->quantity,
    //                     'price' => $cartItem->product->price,
    //                 ]);
    //             }

    //               // Set session data for confirmation
    //               session([
    //                 'order_id' => $order->id,
    //                 'customer_name' => $validatedData['name'],
    //                 'customer_email' => $validatedData['email'],
    //                 'total_amount' => $totalAmount,
    //             ]);
    
    //             // Clear the cart
    //             Cart::where('user_id', Auth::id())->delete();
    
    //             return redirect()->route('orders.confirmation');
    //         } else {
    //             return redirect($paymentIntent->next_action->redirect_to_url->url);
    //         }
    //     } catch (\Exception $e) {
    //         return back()->withErrors(['error' => 'Payment error: ' . $e->getMessage()]);
    //     }
    // }

    public function processPayment(Request $request)
    {
        // dd($request->all());
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'payment_method' => 'required|string|in:Cash on Delivery,Card Payment',
            'payment_method_id' => 'nullable|string', // Only required for card payments
        ]);

        // Fetch cart items and calculate total
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->variation->price * $item->quantity;
        });
        $paymentStatus = '';
        try {
            if ($validatedData['payment_method'] === 'Card Payment') {
                // Process Stripe payment
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $paymentIntent = PaymentIntent::create([
                    'amount' => $totalAmount * 100, // Amount in cents
                    'currency' => 'usd',
                    'payment_method' => $validatedData['payment_method_id'],
                    'confirmation_method' => 'manual',
                    'confirm' => true,
                    'return_url' => route('orders.confirmation'), // Add the return URL
                ]);
                
                
                if ($paymentIntent->status === 'succeeded') {
                    $paymentStatus = 'Paid';
                }

                if ($paymentIntent->status !== 'succeeded') {
                    return redirect($paymentIntent->next_action->redirect_to_url->url);
                }
            }

           
            if ($validatedData['payment_method'] === 'Cash on Delivery') {
                $paymentStatus = 'COD'; // Cash on Delivery status
            }

            // Save order regardless of payment method
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalAmount,
                'status' => $paymentStatus,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'variation_id' => $cartItem->variation->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->variation->price,
                ]);
            }

             // Set session data for confirmation
                  session([
                    'order_id' => $order->id,
                    'customer_name' => $validatedData['name'],
                    'customer_email' => $validatedData['email'],
                    'payment_method' => $validatedData['payment_method'],
                    'total_amount' => $totalAmount,
                ]);

            // Clear the cart
            Cart::where('user_id', Auth::id())->delete();

            return redirect()->route('orders.confirmation');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Payment error: ' . $e->getMessage()]);
        }
    }


    public function confirmation()
    {
        
        $orderId = session('order_id'); // Retrieve the order ID from the session
        // dd($orderId);
        // $order = Order::with('items')->find($orderId); // Fetch the order and related items
        $order = Order::with('items.variation')->find($orderId);
        // dd($order);

        if (!$order) {
            return redirect()->route('home')->withErrors(['error' => 'Order not found']);
        }

        // Get the categories of the first product in the order
    $categories = $order->items->first()->variation->product->categories ?? collect();

    // Fetch related products from the same categories (excluding products in the order)
    $productIdsInOrder = $order->items->pluck('variation.product_id');
    // dd($productIdsInOrder);
    
    $relatedProducts = Product::whereHas('categories', function ($query) use ($categories) {
        $query->whereIn('categories.id', $categories->pluck('id')); // Explicitly qualify 'categories.id'
    })
    ->whereNotIn('products.id', $productIdsInOrder) // Explicitly qualify 'products.id'
    ->take(4)
    ->get();

        // dd($relatedProducts);

        return view('orders.confirmation', [
            'order' => $order,
            'customer_name' => session('customer_name'),
            'customer_email' => session('customer_email'),
            'payment_method' => session('payment_method'),
            'total_amount' => session('total_amount', '0.00'),
            'relatedProducts' => $relatedProducts, // Pass related products to the view
        ]);
    }

    
}
