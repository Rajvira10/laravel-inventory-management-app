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
        <div class="mt-4 d-flex justify-content-start align-items-center">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back to Orders</a>
            <button class="btn btn-primary btn-sm ml-2"><a href={{ route('orders.edit', $order->id) }}
                    class="text-white text-decoration-none">Edit</a>
            </button>
            <form action="{{ route('orders.destroy', $order->id) }}" method="post" class="d-inline ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this order?')">
                    Delete
                </button>
            </form>

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
