@extends('layouts.app')

@section('content')
<h1>Category: {{ $category->name }}</h1>
<div class="row">
    @foreach($products as $product)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text">${{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
