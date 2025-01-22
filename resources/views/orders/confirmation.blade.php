@extends('layouts.app')

@section('content')
<div class="container my-2">
    <!-- Order Confirmation Section -->
    <div class="text-center">
        <h1 class="mt-5 mb-3">Order Confirmed!</h1>
        <p>Thank you for your order.</p>
        <p>Your Order (ID: <strong>{{ $order->id }}</strong>) has been confirmed.</p>
    </div>

    <!-- Order Details Section -->
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
                                <img src="{{ asset($item->variation->product->image) }}" alt="{{ $item->variation->product->name }}" class="img-fluid me-3" style="width: 50px; height: 50px;">
                                {{ $item->variation->product->name }}
                            </td>
                            <td class="align-middle">${{ number_format($item->variation->price, 2) }}</td>
                            <td class="align-middle">{{ $item->quantity }}</td>
                            <td class="align-middle">${{ number_format($item->quantity * $item->variation->price, 2) }}</td>
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

    <!-- Back to Home Button -->
    <div class="mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-danger">Back to Home</a>
    </div>

    <!-- Related Products Section -->
    <div class="related-products mt-5">
        <h3 class="text-center mb-4">Related Products</h3>
        <div class="row justify-content-center g-4">
            @forelse ($relatedProducts as $product)
                <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                    <div class="product-card">
                        <div class="product-image">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            </a>
                            @if($product->is_new)
                                <span class="new-badge">NEW</span>
                            @endif
                        </div>
                        <div class="card-body my-2">
                            <p class="card-title text-center">
                                <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                    <strong>{{ $product->name }}</strong>
                                </a>
</p>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <p class="product-price mb-0">${{ number_format($product->price, 2) }}</p>
                                <!-- <p class="text-muted small mb-0">⭐⭐⭐⭐⭐ ({{ $product->rating_count }})</p> -->
                                <div class="product-rating mb-2">
    @php
        $averageRating = $product->reviews->avg('rating') ?? 0; // Calculate average rating
    @endphp
    <span class="text-warning">
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa fa-star {{ $i <= $averageRating ? 'checked' : '' }}"></i>
        @endfor
    </span>
    <!-- <span class="text-muted">({{ $product->reviews->count() }} Reviews)</span> -->
</div>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No related products found.</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Styles for Related Products -->
<style>
    .related-products .product-card {
        border: 1px solid #ddd;
        overflow: hidden;
        background-color: #fff;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        margin: auto;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .related-products .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .related-products .product-image img {
        width: 100%;
        /* height: auto; */
        /* max-height: 150px; */
        /* object-fit: cover; */

        /* width: 200px; */
        height: 200px;
        object-fit: cover;
        margin: 0 auto;
    }

    .related-products .new-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #00c853;
        color: white;
        font-size: 0.8rem;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 20px;
    }

    .related-products .product-price {
        font-size: 1rem;
        color: #ff5722;
        font-weight: bold;
    }

    .related-products h6 {
        font-size: 1rem;
        font-weight: 600;
        margin: 10px 0 5px;
        color: #333;
    }
    .fa-star {
        color: gray;
    }

    .fa-star.checked {
        color: gold;
    }
</style>
@endsection
