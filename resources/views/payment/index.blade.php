@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payment Information</h2>
    <div class="mb-4">
        <h4>Your Cart:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <!-- <td>{{ $item->product->name }}</td> -->
                        <td class="align-middle">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="img-fluid mx-3" style="width: 100px; height: 80px;">
                            {{ $item->product->name }}
                        </td>
                        <td class="align-middle">${{ number_format($item->product->price, 2) }}</td>
                        <td class="align-middle">{{ $item->quantity }}</td>
                        <td class="align-middle">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h5 class="text-end">Total: ${{ number_format($totalPrice, 2) }}</h5>
    </div>

    <form id="payment-form" action="{{ route('orders.processPayment') }}" method="POST">
        @csrf
        <h4>Your Details:</h4>
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Shipping Address</label>
            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
        </div>

        <h4>Payment Method:</h4>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="Cash on Delivery" required>
            <label class="form-check-label" for="payment_cod">Cash on Delivery</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="Card Payment" required>
            <label class="form-check-label" for="payment_card">Credit/Debit Card</label>
        </div>

        <div id="card-element-container" class="mt-3" style="display: none;">
            <div id="card-element" class="form-control">
                <!-- Stripe Elements will inject the Card Element here -->
            </div>
            <div id="card-errors" class="text-danger mt-2" role="alert"></div>
        </div>

        <button type="submit" class="btn btn-primary mt-3" id="submit-button">Submit Payment</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stripe = Stripe("{{ env('STRIPE_KEY') }}");
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const cardElementContainer = document.getElementById('card-element-container');
    const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');

    // Show or hide the card element container based on selected payment method
    paymentMethodRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'Card Payment') {
                cardElementContainer.style.display = 'block';
            } else {
                cardElementContainer.style.display = 'none';
            }
        });
    });

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        submitButton.disabled = true;

        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (selectedPaymentMethod === 'Card Payment') {
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement,
                billing_details: {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                },
            });

            if (error) {
                document.getElementById('card-errors').textContent = error.message;
                submitButton.disabled = false;
                return;
            }

            // Attach the PaymentMethod ID to the form and submit
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'payment_method_id';
            hiddenInput.value = paymentMethod.id;
            form.appendChild(hiddenInput);
        }

        form.submit();
    });
});
</script>
@endsection
