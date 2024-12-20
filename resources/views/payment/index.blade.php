@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Information</h2>
    <form action="{{ route('orders.processPayment') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Shipping Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
        </div>
        <h4>Payment Method</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="credit_card" id="credit_card" required>
            <label class="form-check-label" for="credit_card">Credit Card</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="paypal" required>
            <label class="form-check-label" for="paypal">PayPal</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="cash_on_delivery" id="cash_on_delivery" required>
            <label class="form-check-label" for="cash_on_delivery">Cash on Delivery</label>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit Payment</button>
    </form>
</div>
@endsection
