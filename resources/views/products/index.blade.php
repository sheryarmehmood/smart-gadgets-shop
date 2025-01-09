@extends('layouts.app')

@section('content')
<style>
    .section-header {
    text-align: left; /* Align the section to the left */
}

.section-tag {
    
    color: #ff4040; /* Red background */
    /* Space between tag and title */
}

.section-title {
    font-size: 1.5rem;
    color: #000; /* Black text */
    margin: 0; /* Remove default margin */
}
s
    /* Custom CSS for specific styles */
    .product-card {
    border: 1px solid #ddd;
    overflow: hidden;
    position: relative;
    background-color: #fff;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    
    display: flex;
    flex-direction: column; /* Ensures content stacks vertically */
    justify-content: space-between; /* Distributes content evenly */
    height: 100%; /* Forces all cards to have the same height */
}

.product-image img {
    width: 200px; /* Full width of the card */
    height: 200px; /* Fixed height for images */
    object-fit: inherit; /* Ensures the image fits nicely without cropping */
    
}

.card-body {
    flex: 1; /* Allows the content to grow or shrink within the card */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
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
        /* border-radius: 20px; */
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

<div class="container py-2">
    <!-- <h2 class="mb-5">Explore Our Products</h2> -->
    <div class="section-header mb-5">
    <div class="section-tag">
    Gadgets
    </div>
    <h2 class="section-title">Explore Our Products</h2>
   
    
</div>

    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-md-3">
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                        @if($product->is_new)
                            <span class="new-badge">NEW</span>
                        @endif
                    </div>
                    
                    
                    <div class="card-body my-2">
                                    <h6 class="card-title">
                        <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">
                            <strong>{{ $product->name }}</strong>
                        </a>
                    </h6>
                    <div class="d-flex gap-2 align-items-center">
                        <p class="product-price mb-0">${{ number_format($product->price, 2) }}</p>
                        <p class="text-muted small mb-0">⭐⭐⭐⭐⭐ ({{ $product->rating_count }})</p>
                    </div>
                    @if($product->old_price)
                        <p class="product-old-price text-center">${{ number_format($product->old_price, 2) }}</p>
                    @endif
                    <!-- <div class="d-flex justify-content-center mt-3">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                    </div> -->
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
