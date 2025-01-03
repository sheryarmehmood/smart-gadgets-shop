@extends('layouts.app')

@section('content')
<style>
    /* Custom CSS for specific styles */
    .product-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        background-color: #fff;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .product-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .new-badge {
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

    .product-price {
        font-size: 1.1rem;
        color: #ff5722;
        font-weight: bold;
    }

    .product-old-price {
        font-size: 0.9rem;
        color: #999;
        text-decoration: line-through;
    }
</style>

<div class="container py-5">
    <h2 class="text-center mb-5">Explore Our Products</h2>
    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card product-card">
                    <div class="product-image">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        @if($product->is_new)
                            <span class="new-badge">NEW</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="product-price">${{ number_format($product->price, 2) }}</p>
                        @if($product->old_price)
                            <p class="product-old-price">${{ number_format($product->old_price, 2) }}</p>
                        @endif
                        <p class="text-muted small">⭐⭐⭐⭐⭐ ({{ $product->rating_count }})</p>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-4 d-flex justify-content-center">
    <nav>
        <ul class="pagination">
            @if ($products->onFirstPage())
                <li class="page-item disabled"><span class="page-link">Previous</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">Previous</a></li>
            @endif

            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                @if ($page == $products->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($products->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">Next</span></li>
            @endif
        </ul>
    </nav>
</div>


</div>
@endsection
