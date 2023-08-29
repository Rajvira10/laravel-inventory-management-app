@extends('layout')

@section('content')
    <div class="container py-5">
        <div class="row mb-4 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-primary">Products</h2>
            <div class="d-flex ">
                <div class="dropdown mr-3">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="{{ route('product.export', ['format' => 'excel']) }}">
                                Excel
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('product.export', ['format' => 'csv']) }}">
                                CSV
                            </a>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('product.create') }}" class="btn btn-success mb-3">Create Product</a>
            </div>

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
                            <td>BDT {{ $product->purchase_price }}</td>
                            <td>BDT {{ $product->selling_price }}</td>
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
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>

    </div>
@endsection
