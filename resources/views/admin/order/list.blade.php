@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between my-2">
            <div class="d-sm-flex align-items-center mb-2 mb-md-0">
                <h1 class="h3 mb-0 text-gray-800">Order List</h1>
            </div>

            <div>
                <form action="" class="d-flex flex-column flex-sm-row" method="get">
                    <div class="input-group mb-2 mb-sm-0">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                            placeholder="Search">
                        <button type="submit" class="btn bg-dark text-white">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <a href="{{ route('admin#orderList') }}" class="btn ms-sm-2">
                        <i class="fa-solid fa-arrows-rotate align-middle"></i>
                    </a>
                </form>
            </div>
        </div>

        <div class="alert alert-info alert-dismissible fade show col-12 col-md-5" role="alert">
            You can click the order code to see the details
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Order Code</th>
                                <th>Customer Name</th>
                                <th class="text-center">Order Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderList as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="link-info">
                                        <a
                                            href="{{ route('admin#orderDetails', $item->order_code) }}">{{ $item->order_code }}</a>
                                    </td>
                                    <td>{{ $item->name ? $item->name : $item->nickname }}</td>
                                    <td>
                                        <select class="form-select" disabled>
                                            <option @if ($item->status == 0) selected @endif>Pending</option>
                                            <option @if ($item->status == 1) selected @endif>Accept</option>
                                            <option @if ($item->status == 2) selected @endif>Reject</option>
                                        </select>
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <div class="btn btn-sm bg-light rounded shadow-sm me-2"><i
                                                    class="fa-solid fa-spinner text-warning"></i></div>
                                        @elseif($item->status == 1)
                                            <div class="btn btn-sm bg-light rounded shadow-sm me-2"><i
                                                    class="fa-solid fa-check text-success"></i></div>
                                        @else
                                            <div class="btn btn-sm bg-light rounded shadow-sm me-2"><i
                                                    class="fa-solid fa-xmark text-danger"></i></div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            @if (count($orderList) == 0)
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No orders found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
