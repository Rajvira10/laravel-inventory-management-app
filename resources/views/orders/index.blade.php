@extends('layout')
@section('content')
    <h2 class="py-5">Orders</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Invoice Number</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Email</th>
                    <th scope="col">Payment Method</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td><a href="orders/{{ $order->id }}"
                                class="text-decoration-none text-dark">{{ $order->invoice_no }}</a></td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            <button class="btn btn-primary"><a href="orders/{{ $order->id }}/edit"
                                    class="text-white text-decoration-none">Edit</a></button>
                            <form action="{{ route('orders.destroy', $order->id) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this order?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
