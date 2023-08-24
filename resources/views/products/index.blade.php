@extends('layout')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Products</h2>

        <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Create Product</a>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Sku</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Purchase Price</th>
                        <th scope="col">Selling Price</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td><a href="products/{{ $product->id }}"
                                    class="text-decoration-none text-dark">{{ $product->name }}</a></td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->purchase_price }}</td>
                            <td>{{ $product->selling_price }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="post"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
