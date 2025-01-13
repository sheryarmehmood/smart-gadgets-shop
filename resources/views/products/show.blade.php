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
            <div class="product-rating mb-3">
                <!-- Average Rating and Review Count -->
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
            <div class="product-price mt-3">
                <h2 class="text-danger">${{ number_format($product->price, 2) }}</h2>
            </div>
            <p class="product-description mt-3">{{ $product->description }}</p>

            <!-- Product Category -->
            <p class="product-category mt-2">
                <strong>Categories:</strong>
                @if($product->categories->isNotEmpty())
                    @foreach($product->categories as $category)
                        {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                    @endforeach
                @else
                    No Categories
                @endif
            </p>

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

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h3>Customer Reviews</h3>

            @if($product->reviews->isEmpty())
                <p>No reviews yet. Be the first to review this product!</p>
            @else
            
                <!-- Display Each Review -->
                @foreach($product->reviews as $review)
                    <div class="review border p-3 mb-3 rounded">
                        <!-- Reviewer's Name -->
                        <strong>{{ $review->user->name }}</strong>

                        <!-- Star Rating -->
                        <div class="text-warning mt-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= $review->rating ? 'checked' : '' }}"></i>
                            @endfor
                        </div>

                        <!-- Review Comment -->
                        <p class="mt-2">{{ $review->comment }}</p>

                        <!-- Review Date -->
                        <small class="text-muted">Reviewed on {{ $review->created_at->format('M d, Y') }}</small>
                    </div>
                @endforeach

            @endif

            <!-- Write a Review Button -->
            
                <a href="{{ route('reviews.create', ['product_id' => $product->id]) }}" class="btn btn-primary mt-3">Write a Review</a>
        
        </div>
    </div>
</div>
@endsection
