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
                        <td>{{ $order->invoice_no }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>
                            <button class="btn btn-primary"><a href="products/{{ $product->id }}/edit"
                                    class="text-white text-decoration-none">Edit</a></button>
                            <button class="btn btn-danger"><a href="products/{{ $product->id }}/edit"
                                    class="text-white text-decoration-none">Delete</a></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
