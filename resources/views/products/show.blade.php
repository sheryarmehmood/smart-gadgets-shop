@extends('layouts.app')

@section('content')
<style>
    .fa-star {
        color: gray;
    }

    .fa-star.checked {
        color: gold;
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: '/';
    }

    .product-title {
        font-weight: bold;
        font-size: 28px;
    }

    .product-rating i.fa-star {
        font-size: 16px;
    }

    .product-rating .checked {
        color: gold;
    }

    .product-price {
        font-size: 24px;
        font-weight: bold;
        color: #dc3545;
    }

    .product-description {
        font-size: 14px;
        line-height: 1.6;
    }

    .variant-options {
        margin: 20px 0;
    }

    .variant-label {
        font-weight: bold;
        margin-right: 10px;
    }

    .color-button {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        border: 1px solid #ccc;
        margin-right: 10px;
        display: inline-block;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .color-button.active {
        border-color: #dc3545;
    }

    .size-button {
        width: 30px;
        height: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 15px;
        display: inline-block;
        text-align: center;
        line-height: 30px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .size-button.active {
        border-color: #dc3545;
    }

    .quantity-section {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }

    .add-to-cart {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .info-box {
        margin-top: 20px;
        font-size: 14px;
        line-height: 1.5;
    }

    .info-box i {
        margin-right: 8px;
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

            <div class="product-rating mb-2">
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

            <div class="product-price mb-3" id="product-price">${{ number_format($product->price, 2) }}</div>

            <p class="product-description">{{ $product->description }}</p>

            <!-- Product Variations -->
            <div class="variant-options">
                <div class="variant-section">
                    <span class="variant-label">Colours:</span>
                    <div id="color-options">
                        @foreach ($product->variations->unique('color') as $variation)
                            <div class="color-button" 
                                data-color="{{ $variation->color }}" 
                                style="background-color: {{ $variation->color }}"></div>
                        @endforeach
                    </div>
                </div>

                <div class="variant-section mt-3">
                    <span class="variant-label">Size:</span>
                    <div id="size-options">
                        <!-- Sizes will be populated dynamically on page load -->
                    </div>
                </div>
            </div>

            <!-- Quantity Selector and Add to Cart -->
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variation_id" id="variation-id">

                <div class="quantity-section mt-5">
                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 70px;text-align:center;">
                    <button type="submit" class="add-to-cart" id="add-to-cart-btn" disabled>ADD TO CART</button>
                </div>
            </form>

            <div class="info-box">
                <p><i class="bi bi-truck"></i> Free Delivery</p>
                <p><i class="bi bi-arrow-repeat"></i> 30 Days Return Policy</p>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Customer Reviews</h3>

            @if($product->reviews->isEmpty())
                <p>No reviews yet!</p>
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
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const colorOptions = document.getElementById('color-options');
        const sizeOptions = document.getElementById('size-options');
        const productPrice = document.getElementById('product-price');
        const variationIdField = document.getElementById('variation-id');
        const addToCartButton = document.getElementById('add-to-cart-btn');

        const variations = @json($product->variations);

        // Display sizes for the first color on page load
        const firstColor = variations[0].color;
        const sizesForFirstColor = variations.filter(variant => variant.color === firstColor);

        const sizeAbbreviations = {
            'Small': 'S',
            'Medium': 'M',
            'Large': 'L'
        };

        sizesForFirstColor.forEach(variant => {
            const button = document.createElement('div');
            button.classList.add('size-button');
            button.dataset.id = variant.id;
            button.dataset.price = variant.price;
            button.textContent = sizeAbbreviations[variant.size] || variant.size.toUpperCase();
            sizeOptions.appendChild(button);
        });

        colorOptions.addEventListener('click', function (e) {
            if (e.target.classList.contains('color-button')) {
                document.querySelectorAll('.color-button').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');
                const selectedColor = e.target.dataset.color;

                sizeOptions.innerHTML = '';
                addToCartButton.disabled = true;

                const sizes = variations.filter(variant => variant.color === selectedColor);
                sizes.forEach(variant => {
                    const button = document.createElement('div');
                    button.classList.add('size-button');
                    button.dataset.id = variant.id;
                    button.dataset.price = variant.price;
                    button.textContent = sizeAbbreviations[variant.size] || variant.size.toUpperCase();
                    sizeOptions.appendChild(button);
                });
            }
        });

        sizeOptions.addEventListener('click', function (e) {
            if (e.target.classList.contains('size-button')) {
                document.querySelectorAll('.size-button').forEach(btn => btn.classList.remove('active'));
                e.target.classList.add('active');

                const price = e.target.dataset.price;
                const variationId = e.target.dataset.id;

                productPrice.textContent = `$${parseFloat(price).toFixed(2)}`;
                variationIdField.value = variationId;
                addToCartButton.disabled = false;
            }
        });
    });
</script>
@endsection
