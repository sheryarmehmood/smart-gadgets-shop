@extends('layouts.app')

@section('content')
<div class="container my-5">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/products">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">Write a Review</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <div class="border p-4 rounded mb-4">
                <h3 class="mb-3">Write a Review</h3>
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="product_id" value="{{ $productId }}">
                    <input type="hidden" name="order_id" value="{{ $orderId }}">

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5 Stars)</label>
                        <div id="rating" class="d-flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" id="star-{{ $i }}" value="{{ $i }}" class="d-none">
                                <label for="star-{{ $i }}" class="fa fa-star text-secondary" style="font-size: 1.5rem; cursor: pointer;"></label>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment (Optional)</label>
                        <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your review..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('label[for^="star-"]');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                stars.forEach(s => s.classList.remove('text-warning'));
                for (let i = 1; i <= this.htmlFor.split('-')[1]; i++) {
                    document.querySelector(`label[for="star-${i}"]`).classList.add('text-warning');
                }
            });
        });
    });
</script>
@endsection
