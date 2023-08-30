@extends('layout')

@section('content')
    <div class="container py-5">
        <div class="row d-flex justify-content-between align-items-center">
            <h2 class="mb-4 fw-bold text-primary">Report</h2>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('report.index') }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search by invoice"
                            value="{{ request()->input('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th scope="col">
                            <a class="text-light"
                                href="{{ route('report.index', ['sort' => 'created_at', 'direction' => $sortColumn === 'created_at' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Date
                                @if ($sortColumn === 'created_at')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up"></i>
                                    @else
                                        <i class="fas fa-arrow-down"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col">
                            <a class="text-light"
                                href="{{ route('report.index', ['sort' => 'invoice_no', 'direction' => $sortColumn === 'invoice_no' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Invoice Number
                                @if ($sortColumn === 'invoice_no')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up"></i>
                                    @else
                                        <i class="fas fa-arrow-down"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                        <th scope="col"><a class="text-light"
                                href="{{ route('report.index', ['sort' => 'p_l', 'direction' => $sortColumn === 'p_l' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                Profit
                                @if ($sortColumn === 'p_l')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up"></i>
                                    @else
                                        <i class="fas fa-arrow-down"></i>
                                    @endif
                                @endif
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginatedorders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td><a href="{{ route('order.show', $order->id) }}"
                                    class="text-decoration-none text-primary">{{ $order->invoice_no }}</a></td>
                            <td>
                                @if ($order->p_l > 0)
                                    <span style="color: rgb(4, 210, 4);">+BDT {{ $order->p_l }}</span>
                                @elseif ($order->p_l < 0)
                                    <span style="color: red;">-BDT {{ -$order->p_l }}</span>
                                @else
                                    ${{ $order->p_l }}
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>


        </div>
        <div class="mt-4">
            {{ $paginatedorders->links() }}
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <div class="mt-5">
            <canvas id="profitLossChart" width="600" height="300"></canvas>
        </div>
        <div class="mt-5">
            <canvas id="ordersPerDayChart" width="600" height="300"></canvas>
        </div>

    </div>



    <script>
        const profitLossData = {!! json_encode($profitLossData) !!};
        const ctx = document.getElementById('profitLossChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: profitLossData.dates,
                datasets: [{
                    label: 'Profit',
                    data: profitLossData.values,
                    borderColor: 'rgb(75, 192, 192)',
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM d'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Profit (BDT)'
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const ordersPerDayData = {!! json_encode($orderCountData) !!};
        const ctxOrders = document.getElementById('ordersPerDayChart').getContext('2d');
        const ordersChart = new Chart(ctxOrders, {
            type: 'bar',
            data: {
                labels: ordersPerDayData.dates,
                datasets: [{
                    label: 'Orders per Day',
                    data: ordersPerDayData.values,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: 'day',
                            displayFormats: {
                                day: 'MMM d'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Orders'
                        }
                    }
                }
            }
        });
    </script>

@endsection
