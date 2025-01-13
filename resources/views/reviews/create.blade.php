@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1>Write a Review</h1>

    <form action="{{ route('reviews.store') }}" method="POST">
        @csrf

        <input type="hidden" name="product_id" value="{{ $productId }}">
        <input type="hidden" name="order_id" value="{{ $orderId }}">

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5 Stars)</label>
            <select name="rating" id="rating" class="form-select" required>
                <option value="">Select a Rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Comment (Optional)</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" placeholder="Write your review..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</div>
@endsection
