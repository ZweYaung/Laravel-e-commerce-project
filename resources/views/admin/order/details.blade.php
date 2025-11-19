@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <a href="{{ route('admin#orderList') }}" class="text-black m-3 d-inline-block"><i
                class="fa-solid fa-arrow-left-long"></i> Back</a>

        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Customer Information</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Name:</div>
                            <div class="col-7">{{ $paymentHistory->user_name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Phone:</div>
                            <div class="col-7">{{ $paymentHistory->phone }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Delivery Address:</div>
                            <div class="col-7">{{ $paymentHistory->address }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Order Code:</div>
                            <div class="col-7" id="orderCode">{{ $order[0]->order_code }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Order Date:</div>
                            <div class="col-7">{{ $order[0]->created_at->format('j-F-Y') }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Total Price:</div>
                            <div class="col-7">
                                {{ number_format($paymentHistory->total_amt) }} MMK
                                <br><small class="text-danger">(Contain Delivery Charges)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Payment Information</div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Contact Phone:</div>
                            <div class="col-7">{{ $paymentHistory->phone }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Payment Method:</div>
                            <div class="col-7">{{ $paymentHistory->payment_type }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 fw-bold">Purchase Date:</div>
                            <div class="col-7">{{ $paymentHistory->created_at }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <a href="{{ asset('payslipImage/' . $paymentHistory->payslip_image) }}">
                                    <img src="{{ asset('payslipImage/' . $paymentHistory->payslip_image) }}"
                                        class="img-fluid img-thumbnail" style="max-width: 200px;">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white py-3">
                <h6 class="m-0 font-weight-bold">Order Board</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm data-table" id="productTable">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="col-2">Image</th>
                                <th>Name</th>
                                <th>Order Count</th>
                                <th>Available Stock</th>
                                <th>Price per Unit</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $item)
                                <tr>
                                    <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                    <input type="hidden" class="count" value="{{ $item->order_count }}">
                                    <td>
                                        <img src="{{ asset('productImage/' . $item->image) }}"
                                            class="img-fluid img-thumbnail" style="max-width: 100px;">
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>
                                        {{ $item->order_count }}
                                        @if ($item->order_count > $item->stock)
                                            <small class="text-danger">(Out of stock)</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->stock }}</td>
                                    <td>{{ number_format($item->price) }} MMK</td>
                                    <td>{{ number_format($item->price * $item->order_count) }} MMK</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end flex-wrap gap-2">
                @if ($status)
                    <input type="button" id="btn-order-accept" class="btn btn-success rounded shadow-sm" value="Accept">
                @endif
                <input type="button" id="btn-order-reject" class="btn btn-danger rounded shadow-sm" value="Reject">
            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script>
        $(document).ready(function() {
            $('#btn-order-accept').click(function() {
                console.log("accept");
                orderCode = $('#orderCode').text();
                orderList = [];

                $('.data-table tbody tr').each(function(index, row) {
                    productId = $(row).find('.productId').val();
                    count = $(row).find('.count').val();

                    orderList.push({
                        'productId': productId,
                        'count': count,
                        'orderCode': orderCode,
                    })
                })

                $.ajax({
                    type: 'get',
                    url: '/admin/order/confirm',
                    data: Object.assign({}, orderList),
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.href = "/admin/order/list" : '';
                    }
                })
            })

            $('#btn-order-reject').click(function() {
                orderCode = $('#orderCode').text();

                $.ajax({
                    type: 'get',
                    url: '/admin/order/reject',
                    data: {
                        'orderCode': orderCode
                    },
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.href = "/admin/order/list" : '';
                    }
                })
            })
        })
    </script>
@endsection
