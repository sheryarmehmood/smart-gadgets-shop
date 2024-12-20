@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mt-5">
        <h1 class="display-4 text-success">Order Confirmed!</h1>
        <p class="lead">Thank you for your purchase, {{ session('customer_name', 'Customer') }}!</p>
        <p>Your order has been successfully placed. A confirmation email has been sent to <strong>{{ session('customer_email', 'your email') }}</strong>.</p>
    </div>
    <hr>
    <div class="mt-4">
        <h4>Order Details:</h4>
        <ul class="list-group">
            <li class="list-group-item"><strong>Order ID:</strong> {{ session('order_id', 'N/A') }}</li>
            <li class="list-group-item"><strong>Payment Method:</strong> {{ session('payment_method', 'N/A') }}</li>
            <li class="list-group-item"><strong>Total Amount:</strong> ${{ session('total_amount', '0.00') }}</li>
        </ul>
    </div>
    <div class="mt-4">
        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
    </div>
</div>
@endsection
