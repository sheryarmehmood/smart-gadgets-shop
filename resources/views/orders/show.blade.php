@extends('layouts.app')

@section('content')
<div class="container my-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/products">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="border p-4 rounded mb-4">
                <h3 class="mb-3">Order Summary</h3>
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Total Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>

            <h3 class="mb-3">Products</h3>
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Review</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td class="align-middle">
                        <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid mx-3" style="width: 100px; height: 80px;">
                        {{ $item->product->name }}
                        </td>
                        <td class="align-middle">{{ $item->quantity }}</td>
                        <td class="align-middle">${{ number_format($item->price, 2) }}</td>
                        <td class="align-middle">
                        <a href="{{ route('reviews.create', ['product_id' => $item->product->id, 'order_id' => $order->id]) }}" class="btn btn-danger btn-sm">Share Review</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
