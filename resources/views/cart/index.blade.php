@extends('layouts.app')

@section('content')
<div class="container my-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/products">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cart</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <!-- <h1 class="mb-4">Your Cart</h1> -->
            @if($cartItems->isEmpty())
                <p>Your cart is empty.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Return to Shop</a>
            @else
                <!-- Cart Table -->
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>
                                    <!-- <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="img-fluid rounded me-3" style="width: 100px; height: 80px;"> -->
                                    {{ $item->product->name }}
                                </td>
                                <td>${{ number_format($item->product->price, 2) }}</td>
                                <td>
                                {{ $item->quantity }}
                                    <!-- <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex"> -->
                                        <!-- @csrf -->
                                        <!-- @method('PATCH') -->
                                        <!-- <input name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm me-2" style="width: 70px;" readonly> -->
                                        <!-- <button type="submit" class="btn btn-sm btn-primary">Update</button> -->
                                    <!-- </form> -->
                                </td>
                                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>

                                <td class="text-center">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 border-0" style="background-color: #dc3545; border-radius: 50%; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px;" title="Remove">
                                            &times;
                                        </button>
                                    </form>
                                </td>

                                <!-- <td class="text-center">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 border-0 bg-transparent text-danger" title="Remove">
                                            &#10060;
                                        </button>
                                    </form>
                                </td> -->


                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Cart Total Section -->
                <div class="row mt-4">
                    <div class="col-md-8">
                        <a href="{{ route('products.index') }}" class="btn btn-danger">Return to Shop</a>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="border p-3 rounded">
                            <h4>Cart Total</h4>
                            <p class="mb-1"><strong>Subtotal:</strong> ${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</p>
                            <p class="mb-1"><strong>Shipping:</strong> Free</p>
                            <p class="mb-3"><strong>Total:</strong> ${{ number_format($cartItems->sum(fn($item) => $item->product->price * $item->quantity), 2) }}</p>
                            <a href="{{ route('orders.payment') }}" class="btn btn-danger w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
