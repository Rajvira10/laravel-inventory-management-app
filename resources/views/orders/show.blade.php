@extends('layout')

@section('content')
    <div class="container">
        <h1>Order Details</h1>
        <div class="card mb-4">
            <div class="card-header">
                Order Information
            </div>
            <div class="card-body">
                <p><strong>Invoice No:</strong> {{ $order->invoice_no }}</p>
                <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Customer Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
        </div>

        <h2>Sold Items</h2>
        <div class="card">
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
                                <td>{{ $soldItem->product_name }}</td>
                                <td>{{ $soldItem->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
