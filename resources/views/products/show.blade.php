@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/products">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image Section -->
        <div class="col-md-6">
            <div class="main-product-image text-center">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 100%; height:500px;">
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-md-6">
            <h1 class="product-title">{{ $product->name }}</h1>
            <div class="product-rating">
                <span class="text-warning">⭐⭐⭐⭐⭐</span>
                <span class="text-muted">({{ $product->rating_count }} Reviews)</span>
                <span class="text-success ms-2">In Stock</span>
            </div>
            <div class="product-price mt-3">
                <h2 class="text-danger">${{ number_format($product->price, 2) }}</h2>
            </div>
            <p class="product-description mt-3">{{ $product->description }}</p>

            <!-- Quantity Selector and Add to Cart -->
            <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="form-group d-flex align-items-center">
                    <label for="quantity" class="me-2">Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control w-25 me-3">
                    <button type="submit" class="btn btn-danger">ADD TO CART</button>
                </div>
            </form>

            <!-- Additional Information -->
            <div class="additional-info mt-4">
                <p><i class="bi bi-truck"></i> Free Delivery</p>
                <p><i class="bi bi-arrow-repeat"></i> Return Delivery (30 Days Return Policy)</p>
            </div>
        </div>
    </div>
</div>
@endsection
