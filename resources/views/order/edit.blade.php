@extends('layout')

@section('content')
    <div class="container">
        <h2>Edit Order</h2>
        <div class="card text-start">
            <div class="card-header">
                Order Information
            </div>
            <div class="card-body">
                <form action="{{ route('order.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="customer_name">Customer Name:</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ $order->customer_name }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Customer Email:</label>
                        <input type="email" name="customer_email" class="form-control"
                            value="{{ $order->customer_email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method:</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="credit_card" {{ $order->payment_method === 'credit_card' ? 'selected' : '' }}>
                                Credit Card</option>
                            <option value="paypal" {{ $order->payment_method === 'paypal' ? 'selected' : '' }}>PayPal
                            </option>
                            <option value="Cash" {{ $order->payment_method === 'Cash' ? 'selected' : '' }}>Cash</option>
                        </select>
                    </div>

                    <div class="card mt-2">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->soldItems as $soldItem)
                                        <tr>
                                            <td>
                                                <select name="product_id[]" class="form-control" required>
                                                    @foreach ($allproducts as $product)
                                                        <option
                                                            {{ $product->id === $soldItem->product_id ? 'selected' : '' }}
                                                            value="{{ $product->id }}">{{ $product->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input class="form-control" type="number" value="{{ $soldItem->quantity }}"
                                                    name="product_quantity[]"></td>
                                            <td><button type="button"
                                                    class="btn btn-danger btn-sm delete-row">Delete</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="addProduct">Add Product</button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-4">Update Order</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Inside your existing script tag -->
    <script>
        document.getElementById('addProduct').addEventListener('click', function() {
            var tableBody = document.querySelector('table tbody');
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>
                <select name="product_id[]" class="form-control" required>
                    @foreach ($allproducts as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="product_quantity[]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
        `;

            tableBody.appendChild(newRow);
        });

        // Delete button functionality
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('delete-row')) {
                var row = event.target.closest('tr');
                row.remove();
            }
        });
    </script>
@endsection
