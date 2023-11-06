@extends('layout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Welcome to Your Dashboard, {{ Auth::user()->name }}</h1>

        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        Your Orders
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.export', ['format' => 'excel']) }}">
                                        Excel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.export', ['format' => 'csv']) }}">
                                        CSV
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($orders->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Order ID</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                            <td><a href="{{ route('dashboard.show', $order->id) }}">{{ $order->id }}</a>
                                            </td>
                                            <td>${{ $order->amount }}</td>
                                            <td class="text-capitalize">{{ $order->status }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $orders->links() }}
                            </div>
                        @else
                            <p>No orders available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        Profile Information2
                    </div>
                    <div class="card-body">
                        <p>Name: {{ Auth::user()->name }}</p>
                        <p>Email: {{ Auth::user()->email }}</p>
                        <a href="{{ route('user_order.create') }}" class="btn btn-primary">Create Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
