@extends('layouts.app')

@section('content')
<div class="container my-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            @if($orders->isEmpty())
                <p>You have no orders yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
            @else
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="align-middle">{{ $order->id }}</td>
                            <td class="align-middle">${{ number_format($order->total_price, 2) }}</td>
                            <td class="align-middle">{{ ucfirst($order->status) }}</td>
                            <td class="align-middle text-center">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-danger btn-sm">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
