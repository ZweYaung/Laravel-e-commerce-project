@extends('user.layouts.master')

@section('content')
    <div class="container-fluid pb-5">
        <section id="billboard" class="border-bottom py-3 mb-3">
            <div class="container">
                <div class="row justify-content-center">
                    <h1 class="fs-1 text-center mt-4">
                        CHECKOUT
                    </h1>
                </div>
            </div>
        </section>
        <div class="row mb-3 d-flex justify-content-between align-items-center p-3">
            <!-- Left Side: Back Button -->
            <div class="col-auto">
                <a href="{{ route('user#cart') }}" class="btn-link fs-5 text-dark">Back</a>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <h5 class="mb-4">Payment methods</h5>

                            @foreach ($paymentAcc as $item)
                                <div class=""><b>{{ $item->type }}</b> ( Name : {{ $item->account_name }})</div>

                                Account : {{ $item->account_number }}

                                <hr />
                            @endforeach
                        </div>
                        <div class="col">
                            <div class="card shadow-sm">
                                <div class="card-header">Payment Information</div>
                                <div class="card-body">
                                    <div class="">
                                        <form action="{{ route('user#order') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="text" name="name" id=""
                                                        value="{{ old('name') }}"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        placeholder="Name" />
                                                    @error('name')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="text" name="phone" id=""
                                                        value="{{ old('phone') }}"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        placeholder="09xxxxxxxx" />
                                                    @error('phone')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col">
                                                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Delivery Address"
                                                            id="" cols="30" rows="3">{{ old('address') }}</textarea>
                                                        @error('address')
                                                            <small class="invalid-feedback">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2 offset-7">
                                                <small>Upload the screenshot of the payment</small>
                                            </div>
                                            <div class="row">
                                                <div class="col">

                                                    <select name="paymentType" id=""
                                                        class="form-select @error('paymentType') is-invalid @enderror">
                                                        <option value="">
                                                            Choose Payment Method
                                                        </option>
                                                        @foreach ($paymentAcc as $item)
                                                            <option value="{{ $item->id }}"
                                                                @if (old('paymentType') == $item->id) selected @endif>
                                                                {{ $item->type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('paymentType')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <input type="file" accept="image/*" name="payslipImage"
                                                        id=""
                                                        class="form-control @error('payslipImage') is-invalid @enderror" />
                                                    @error('payslipImage')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col">
                                                    <input type="hidden" name="orderCode"
                                                        value="{{ $orderTemp[0]['order_code'] }}" />
                                                    Order Code :
                                                    <span
                                                        class="text-primary fw-bold">{{ $orderTemp[0]['order_code'] }}</span>
                                                </div>
                                                <div class="col">
                                                    <input type="hidden" name="totalAmount"
                                                        value="{{ $orderTemp[0]['finalAmt'] }}" />
                                                    Total : <span
                                                        class="fw-bold">{{ number_format($orderTemp[0]['finalAmt']) }}
                                                        MMK</span>
                                                </div>
                                            </div>

                                            <div class="row mt-4 mx-2">
                                                <button type="submit" class="btn btn-outline-secondary rounded w-100">
                                                    <i class="fa-solid fa-cart-shopping me-3"></i>Place
                                                    Order
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
