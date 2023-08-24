@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="text-start">
            <h2>Edit Product</h2>
            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                </div>
                <div class="mb-3">
                    <label for="sku" class="form-label">Sku:</label>
                    <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku }}">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="{{ $product->stock }}">
                </div>
                <div class="mb-3">
                    <label for="purchase_price" class="form-label">Purchase Price:</label>
                    <input type="number" class="form-control" id="purchase_price" name="purchase_price"
                        value="{{ $product->purchase_price }}">
                </div>
                <div class="mb-3">
                    <label for="selling_price" class="form-label">Selling Price:</label>
                    <input type="number" class="form-control" id="selling_price" name="selling_price"
                        value="{{ $product->selling_price }}">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea type="text" class="form-control" id="description" name="description">{{ $product->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image:</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid mb-4">
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
@endsection
