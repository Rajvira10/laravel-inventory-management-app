@extends('layout')
@section('content')
    <div class="container py-5">
        <div class="row d-flex justify-content-between align-items-center">
            <h2 class="mb-4 fw-bold text-primary">Orders</h2>
            <a href="{{ route('order.create') }}" class="btn btn-success mb-3">Create Order</a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Customer Email</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><a href="{{ route('order.show', $order->id) }}"
                                    class="text-decoration-none text-primary">{{ $order->invoice_no }}</a></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_email }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm"><a href="{{ route('order.edit', $order->id) }}"
                                        class="text-white text-decoration-none">Edit</a></button>
                                <form action="{{ route('order.delete', $order->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this order?')">
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