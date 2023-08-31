@extends('layout')

@section('content')
    <form action="{{ route('dashboard.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                Order Information
            </div>
            <div class="card-body">
                <p><strong class="text-secondary">Customer Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong class="text-secondary">Customer Email:</strong> {{ auth()->user()->email }}</p>
                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="Cash">Cash</option>
                    </select>
                    @error('payment_method')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="product_id[]" class="form-control product-list" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input class="form-control product-quantity" type="number" name="product_quantity[]"
                                    value="0"></td>
                            <td class="product-subtotal">BDT 0</td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total:</strong></td>
                            <td id="totalAmount" class="text-secondary">BDT 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <button type="button" class="btn btn-info btn-sm mt-2" id="addProduct">Add Product</button>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-lg mt-5">Create Order</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Selectr(document.querySelector('.product-list'));
        })

        document.getElementById('addProduct').addEventListener('click', function() {
            var tableBody = document.querySelector('table tbody');
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td>
                <select name="product_id[]" class="form-control product-list" required>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="product_quantity[]" class="form-control product-quantity" value="0"></td>
            <td class="product-subtotal">BDT 0</td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
        `;

            tableBody.appendChild(newRow);
            new Selectr(newRow.querySelector('.product-list'));
        });

        // Delete button functionality
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('delete-row')) {
                var row = event.target.closest('tr');
                row.remove();
            }
        });

        // Calculate subtotal in real-time
        document.addEventListener('input', function(event) {
            if (event.target && (event.target.classList.contains('product-quantity') || event.target.classList
                    .contains('product-list'))) {
                updateSubtotals();
            }
        });

        function updateSubtotals() {
            const rows = document.querySelectorAll('table tbody tr');
            let total = 0;

            rows.forEach((row) => {
                const quantity = parseFloat(row.querySelector('.product-quantity').value);
                const price = parseFloat(row.querySelector('.product-list').value);
                const subtotal = quantity * price;

                total += subtotal;

                row.querySelector('.product-subtotal').textContent = "BDT " + subtotal.toFixed(0);
            });

            document.getElementById('totalAmount').textContent = "BDT " + total.toFixed(0);
        }
        updateSubtotals();
    </script>
@endsection
