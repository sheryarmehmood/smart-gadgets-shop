@extends('layouts.app')

@section('content')
<style>
    .section-header {
        text-align: left;
    }

    .section-tag {
        color: #ff4040;
    }

    .section-title {
        font-size: 1.5rem;
        color: #000;
        margin: 0;
    }

    .hero-banner {
        width: 100%; /* Full width */
        height: auto; /* Maintain aspect ratio */
        object-fit: cover; /* Ensures the image is fully visible */
        margin-bottom: 20px; /* Adds spacing below the banner */
    }

    .product-card {
        border: 1px solid #ddd;
        overflow: hidden;
        position: relative;
        background-color: #fff;
        text-align: center;
        /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        margin: auto;
    }

    .product-image img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        margin: 0 auto;
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
        font-size: 1rem;
        color: #ff5722;
        font-weight: bold;
    }

    .product-old-price {
        font-size: 0.8rem;
        color: #999;
        text-decoration: line-through;
    }

    @media (max-width: 992px) {
        .product-card {
            max-width: 220px; /* Limit the card width for tablets */
        }
    }

    @media (max-width: 768px) {
        .product-card {
            max-width: 180px; /* Smaller cards for smaller screens */
        }

        .product-image img {
            width: 150px;
            height: 150px; /* Adjust image size */
        }

        .product-price {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .product-card {
            max-width: 160px; /* Smallest size for cards */
        }

        .product-image img {
            width: 120px;
            height: 120px; /* Adjust image size */
        }

        .product-price {
            font-size: 0.8rem;
        }
    }
</style>


<div class="container-fluid px-0">
    <!-- Hero Banner -->
    <div>
        <img src="{{ asset('images/banner.png') }}" alt="Hero Banner" class="hero-banner">
    </div>

  <div class="container py-4">
    <div class="section-header mb-5 text-center">
        <!-- <div class="section-tag">Gadgets</div> -->
        <h2 class="section-title">Explore Our <span class="section-tag">Gadgets</span></h2>
    </div>

    <div class="row justify-content-center g-4">
        @foreach($products as $product)
            <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
                <div class="product-card">
                    <div class="product-image">
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
</a>

                        <!-- <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}"> -->
                        @if($product->is_new)
                            <span class="new-badge">NEW</span>
                        @endif
                    </div>
                    <div class="card-body my-2">
                        <h6 class="card-title text-center">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                                <strong>{{ $product->name }}</strong>
                            </a>
                        </h6>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <p class="product-price mb-0">${{ number_format($product->price, 2) }}</p>
                            <p class="text-muted small mb-0">⭐⭐⭐⭐⭐ ({{ $product->rating_count }})</p>
                        </div>
                        @if($product->old_price)
                            <p class="product-old-price text-center">${{ number_format($product->old_price, 2) }}</p>
                        @endif
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
</div>
@endsection
