@extends('layouts.app')

@section('content')
<div class="container my-2">
    <div class="text-center">
        <h1 class="mt-5 mb-3">Order Confirmed !</h1>
        <p>Thank you for your order</p>
        <p>Your Order (ID: <strong>{{ $order->id }}</strong>) has been confirmed.</p>
    </div>

    <div class="mt-4">
        <div class="card-body">
            <h4 class="mb-3">Order Details</h4>
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="d-flex align-items-center align-middle">
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid me-3" style="width: 50px; height: 50px;">
                                {{ $item->product->name }}
                            </td>
                            <td class="align-middle">${{ number_format($item->price, 2) }}</td>
                            <td class="align-middle">{{ $item->quantity }}</td>
                            <td class="align-middle">${{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <p><strong>Total Amount:</strong> ${{ number_format($total_amount, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($payment_method) }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-danger">Back to Home</a>
    </div>
</div>
@endsection
