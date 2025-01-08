@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Confirmation</h1>
    <p>Thank you, {{ $customer_name }}!</p>
    <p>Your order (ID: {{ $order->id }}) has been confirmed.</p>

    <h4>Order Details</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Amount:</strong> ${{ number_format($total_amount, 2) }}</p>

    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
</div>
@endsection
