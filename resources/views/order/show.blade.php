@extends('layout')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1 class="text-primary">Order Details</h1>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                Order Information
            </div>
            <div class="card-body">
                <p><strong class="text-secondary">Invoice No:</strong> {{ $order->invoice_no }}</p>
                <p><strong class="text-secondary">Customer Name:</strong> {{ $order->customer_name }}</p>
                <p><strong class="text-secondary">Customer Email:</strong> {{ $order->customer_email }}</p>
                <p><strong class="text-secondary">Payment Method:</strong> {{ $order->payment_method }}</p>
                <p><strong class="text-secondary">Created At:</strong> {{ $order->created_at->format('F j, Y g:i A') }}</p>
                <p><strong class="text-secondary">Updated At:</strong> {{ $order->updated_at->format('F j, Y g:i A') }}</p>
                <p><strong class="text-success">Total Price:</strong> BDT {{ $order->amount }} </p>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-start align-items-center">
            <a href="{{ route('order.index') }}" class="btn btn-secondary">Back to Orders</a>
            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary btn-sm ml-2">Edit</a>
            <form action="{{ route('order.delete', $order->id) }}" method="post" class="d-inline ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
            </form>
        </div>

        <div class="mt-4">
            <h2 class="text-success">Sold Items</h2>
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr class="text-right">
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->soldItems as $index => $soldItem)
                                <tr class="text-right">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $soldItem->product_name }}</td>
                                    <td>{{ $soldItem->quantity }}</td>
                                    <td>BDT {{ $soldItem->unit_price }}</td>
                                    <td>BDT {{ $soldItem->subtotal }}</td>
                                </tr>
                            @endforeach
                            <tr class="text-right">
                                <td colspan="4"><strong>Total:</strong></td>
                                <td><strong>BDT {{ $order->amount }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
