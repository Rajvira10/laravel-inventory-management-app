@extends('layout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Welcome to Your Dashboard, {{ Auth::guard('admin')->user()->name }}</h1>

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Your Orders
                    </div>
                    {{-- <div class="card-body">
                        @if ($orders->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                            <td><a href="{{ route('dashboard.show', $order->id) }}">{{ $order->id }}</a>
                                            </td>
                                            <td>${{ $order->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No orders available.</p>
                        @endif
                    </div> --}}
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Profile Information
                    </div>
                    <div class="card-body">
                        <p>Name: {{ Auth::guard('admin')->user()->name }}</p>
                        <p>Email: {{ Auth::guard('admin')->user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
