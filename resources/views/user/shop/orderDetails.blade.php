@extends('user.layouts.master')

@section('content')
    <div class="container-fluid">
        <section id="billboard" class="border-bottom py-3 mb-3">
            <div class="container">
                <div class="row justify-content-center">
                    <h1 class="fs-1 text-center mt-4">
                        ORDER DETAILS
                    </h1>
                </div>
            </div>
        </section>


        <div class="row mb-3 d-flex justify-content-between align-items-center p-3">
            <!-- Left Side: Back Button -->
            <div class="col-auto">
                <a href="{{ route('user#orderList') }}" class="btn-link fs-5 text-dark">Back</a>
            </div>
        </div>

        <!-- DataTales Example -->


        <div class="row">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table text-center mb-0" id="productTable">
                    <thead class="text-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">

                        @foreach ($order as $item)
                            <tr>
                                {{-- <td class="align-middle text-center">
                                    <img src="{{ asset('productImage/' . $item->image) }}" alt="Product Image"
                                        class="rounded"
                                        style="width: 100px; height: 100px; object-fit: contain; border-radius: 8px;" />
                                </td> --}}
                                <td class="align-middle text-center">
                                    <img style="width: 100px; height: 100px; object-fit: contain;"
                                        src="{{ asset('productImage/' . $item->image) }}">
                                </td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->order_count }}</td>
                                <td>{{ number_format($item->price) }} MMK</td>
                                <td>{{ number_format($item->price * $item->order_count) }} MMK</td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>

            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="card shadow-sm m-4 col">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-5">Name :</div>
                                <div class="col-7"> {{ $paymentHistory->user_name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">Phone :</div>
                                <div class="col-7">
                                    {{ $paymentHistory->phone }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">Delivery Address :</div>
                                <div class="col-7">
                                    {{ $paymentHistory->address }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">Order Code :</div>
                                <div class="col-7" id="orderCode"> {{ $order[0]->order_code }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">Order Date : </div>
                                <div class="col-7">{{ $order[0]->created_at->format('j-F-Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">Total Price : </div>
                                <div class="col-7">
                                    {{ number_format($paymentHistory->total_amt) }} MMK<br>
                                    <small class=" text-danger ms-1">( Contain Delivery Charges )</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card shadow-sm m-4 col">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-5">Contact Phone :</div>
                                    <div class="col-7">{{ $paymentHistory->phone }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">Payment Method :</div>
                                    <div class="col-6">{{ $paymentHistory->payment_type }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-5">Purchase Date :</div>
                                    <div class="col-7">{{ $paymentHistory->created_at }}</div>
                                </div>
                                <div class="row mb-3 ">
                                    <a href="{{ asset('payslipImage/' . $paymentHistory->payslip_image) }}"><img
                                            style="width: 150px"
                                            src="{{ asset('payslipImage/' . $paymentHistory->payslip_image) }}"
                                            class=" img-thumbnail"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    @endsection
