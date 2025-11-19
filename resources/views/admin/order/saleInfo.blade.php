@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <h1 class="h3 text-gray-800">Sale Information</h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Date</th>
                                <th>Order Code</th>
                                <th>Customer Name</th>
                                <th>Order Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($saleInfo) != 0)
                                @foreach ($saleInfo as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('j-F-Y') }}</td>
                                        <td class="text-primary">{{ $item->order_code }}</td>
                                        <td>{{ $item->user_name ? $item->user_name : $item->nickname }}</td>
                                        <td>
                                            <select class="form-select statusChange">
                                                <option value="{{ $item->status }}">Accepted</option>
                                            </select>
                                        </td>
                                        <td>
                                            <i class="fa-solid fa-check text-success"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-muted text-center">There is no order</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $saleInfo->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
