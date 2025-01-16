@extends('layouts.app')

@section('content')
<style>
    .fa-star {
        color: gray;
    }

    .fa-star.checked {
        color: gold;
    }
</style>

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
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
            <div class="product-rating mb-3">
                @php
                    $averageRating = $product->reviews->avg('rating') ?? 0;
                @endphp
                <span class="text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa fa-star {{ $i <= $averageRating ? 'checked' : '' }}"></i>
                    @endfor
                </span>
                <span class="text-muted">({{ $product->reviews->count() }} Reviews)</span>
            </div>

            <!-- Product Price -->
            <div class="product-price mt-3">
                <h2 class="text-danger" id="product-price">${{ number_format($product->price, 2) }}</h2>
            </div>

            <p class="product-description mt-3">{{ $product->description }}</p>

            <!-- Product Variants -->
            <form id="variant-form">
                @csrf
                <input type="hidden" id="product-id" value="{{ $product->id }}">

                <div class="form-group mt-4">
                    <label for="color">Color:</label>
                    <select id="color" class="form-control" name="color" required>
                        <option value="" disabled selected>Select Color</option>
                        @foreach ($product->variations->unique('color') as $variation)
                            <option value="{{ $variation->color }}">{{ ucfirst($variation->color) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-4">
                    <label for="size">Size:</label>
                    <select id="size" class="form-control" name="size" disabled required>
                        <option value="" disabled selected>Select Size</option>
                    </select>
                </div>
            </form>

            <!-- Quantity Selector and Add to Cart -->
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variation_id" id="variation-id">
                <div class="form-group d-flex align-items-center mt-4">
                    <label for="quantity" class="me-2">Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" class="form-control w-25 me-3">
                    <button type="submit" class="btn btn-danger" id="add-to-cart-btn" disabled>ADD TO CART</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Customer Reviews</h3>

            @if($product->reviews->isEmpty())
                <p>No reviews yet. Be the first to review this product!</p>
            @else
                @foreach($product->reviews as $review)
                    <div class="review border p-3 mb-3 rounded">
                        <strong>{{ $review->user->name }}</strong>
                        <div class="text-warning mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= $review->rating ? 'checked' : '' }}"></i>
                            @endfor
                        </div>
                        <p class="mt-2">{{ $review->comment }}</p>
                        <small class="text-muted">Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                @endforeach
            @endif

            <a href="{{ route('reviews.create', ['product_id' => $product->id]) }}" class="btn btn-primary mt-3">Write a Review</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colorSelect = document.getElementById('color');
        const sizeSelect = document.getElementById('size');
        const productPrice = document.getElementById('product-price');
        const variationIdField = document.getElementById('variation-id');
        const addToCartButton = document.getElementById('add-to-cart-btn');

        // Update size dropdown based on color selection
        colorSelect.addEventListener('change', function () {
            const selectedColor = colorSelect.value;
            sizeSelect.disabled = false;
            sizeSelect.innerHTML = '<option value="" disabled selected>Select Size</option>';

            const variations = @json($product->variations);

            variations.forEach(variant => {
                if (variant.color === selectedColor) {
                    const option = document.createElement('option');
                    option.value = variant.id; // Use variation ID for the option value
                    option.textContent = variant.size;
                    option.dataset.price = variant.price;
                    sizeSelect.appendChild(option);
                }
            });
        });

        // Update price and enable add-to-cart button when size is selected
        sizeSelect.addEventListener('change', function () {
            const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
            if (selectedOption) {
                const price = selectedOption.dataset.price;
                const variationId = selectedOption.value;

                // Update price and variation ID
                productPrice.textContent = `$${parseFloat(price).toFixed(2)}`;
                variationIdField.value = variationId;

                // Enable the Add to Cart button
                addToCartButton.disabled = false;
            }
        });
    });
</script>
@endsection
