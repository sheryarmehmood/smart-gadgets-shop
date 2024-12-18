@extends('layouts.app')

@section('content')
<h1>Your Orders</h1>
<!-- @if($orders->isEmpty()) -->
    <!-- <p>You have no orders.</p> -->
<!-- @else -->
    <ul class="list-group">
        @foreach($orders as $order)
            <li class="list-group-item">
                Order #{{ $order->id }} - Total: ${{ number_format($order->total_price, 2) }} - Status: {{ ucfirst($order->status) }}
            </li>
        @endforeach
    </ul>
<!-- s@endif -->
@endsection
