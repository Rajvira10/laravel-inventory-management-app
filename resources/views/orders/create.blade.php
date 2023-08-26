@extends('layout')

@section('content')
    <div class="container text-start">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header text-black">
                        <h1 class="h3">Create New Order</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="customer_name">Customer Name:</label>
                                <input type="text" name="customer_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_email">Customer Email:</label>
                                <input type="email" name="customer_email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="payment_method">Payment Method:</label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="Cash">Cash</option>
                                </select>
                            </div>

                            <div id="product-fields">
                                <div class="product-field">
                                    <div class="form-group">
                                        <label for="product">Product:</label>
                                        <select name="product_ids[]" class="form-control" required>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" name="quantities[]" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-product" class="btn btn-secondary">Add Product</button>

                            <button type="submit" class="btn btn-primary btn-block mt-4">Create Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addProductButton = document.getElementById("add-product");
        const productFieldsContainer = document.getElementById("product-fields");

        addProductButton.addEventListener("click", function() {
            const productField = document.querySelector(".product-field").cloneNode(true);
            productFieldsContainer.appendChild(productField);
        });
    });
</script>
