@extends('layout')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid rounded mb-4">
            </div>
            <div class="col-md-6">
                <h2 class="mb-4 text-primary">{{ $product->name }}</h2>
                <hr class="bg-primary">
                <p class="text-secondary"><strong>SKU:</strong> {{ $product->sku }}</p>
                <p class="text-secondary"><strong>Stock:</strong> {{ $product->stock }}</p>
                <p class="text-secondary"><strong>Purchase Price:</strong> BDT {{ $product->purchase_price }}</p>
                <p class="text-secondary"><strong>Selling Price:</strong> BDT {{ $product->selling_price }}</p>
                <div class="mb-4">
                    <strong class="text-secondary">Description:</strong>
                    <p>{{ $product->description ?: 'No description available.' }}</p>
                </div>
                <div>
                    <button class="btn btn-primary"><a href="{{ $product->id }}/edit"
                            class="text-white text-decoration-none">Edit</a></button>
                    <form action="{{ route('product.delete', $product->id) }}" method="post" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('product.index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
@endsection
