@extends('layout')

@section('content')
    <div class="container py-5">
        <div class="row d-flex justify-content-between align-items-center">
            <h2 class="mb-4 fw-bold text-primary">Products</h2>
            <a href="{{ route('product.create') }}" class="btn btn-success mb-3">Create Product</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Sku</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Purchase Price</th>
                        <th scope="col">Selling Price</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><a href="{{ route('product.show', $product->id) }}"
                                    class="text-decoration-none text-primary">{{ $product->name }}</a></td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>${{ $product->purchase_price }}</td>
                            <td>${{ $product->selling_price }}</td>
                            <td>
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('product.delete', $product->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="confirm('Are you sure you want to delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
