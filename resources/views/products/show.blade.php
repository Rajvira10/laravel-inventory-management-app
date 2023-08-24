@extends('layout')
@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <img src="https://picsum.photos/500/300" alt="Product Image" class="img-fluid mb-4">
            </div>
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <hr>
                <p><strong>SKU:</strong> {{ $product->sku }}</p>
                <p><strong>Stock:</strong> {{ $product->stock }}</p>
                <p><strong>Purchase Price:</strong> ${{ $product->purchase_price }}</p>
                <p><strong>Selling Price:</strong> ${{ $product->selling_price }}</p>
                <div class="mb-4">
                    <strong>Description:</strong>
                    <p>{{ $product->description ?: 'No description available.' }}</p>
                </div>
                <div>
                    <button class="btn btn-primary"><a href="{{ $product->id }}/edit"
                            class="text-white text-decoration-none">Edit</a></button>
                    <button class="btn btn-danger"><a href="products/{{ $product->id }}/edit"
                            class="text-white text-decoration-none">Delete</a></button>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
@endsection
