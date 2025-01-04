@extends('layouts.app')

@section('content')
<h1 class="card-title">{{ $product->name }}</h1>
<img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
<p>{{ $product->description }}</p>
<p>Price: ${{ number_format($product->price, 2) }}</p>
<form action="{{ route('cart.store') }}" method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Add to Cart</button>
</form>
@endsection
