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
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->created_at->format('d-m-Y') }}</td>
                            <td><a href="{{ route('order.show', $order->id) }}"
                                    class="text-decoration-none text-primary">{{ $order->invoice_no }}</a></td>
                            <td>
                                @if ($order->p_l > 0)
                                    <span style="color: rgb(4, 210, 4);">+${{ $order->p_l }}</span>
                                @elseif ($order->p_l < 0)
                                    <span style="color: red;">-${{ -$order->p_l }}</span>
                                @else
                                    ${{ $order->p_l }}
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>


        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
