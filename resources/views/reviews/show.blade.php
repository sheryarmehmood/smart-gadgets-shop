<div class="product-rating">
    <h3>Average Rating: 
        @for ($i = 1; $i <= 5; $i++)
            <span class="fa fa-star {{ $i <= $product->averageRating() ? 'checked' : '' }}"></span>
        @endfor
        ({{ number_format($product->averageRating(), 1) }} Stars)
    </h3>

    <h4>Customer Reviews</h4>
    @forelse ($product->reviews as $review)
        <div class="review">
            <strong>{{ $review->user->name }}</strong>
            <div>
                @for ($i = 1; $i <= 5; $i++)
                    <span class="fa fa-star {{ $i <= $review->rating ? 'checked' : '' }}"></span>
                @endfor
            </div>
            <p>{{ $review->comment }}</p>
        </div>
    @empty
        <p>No reviews yet. Be the first to review this product!</p>
    @endforelse
</div>
