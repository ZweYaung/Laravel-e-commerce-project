@extends('user.layouts.master')

@section('content')

    <!-- Cart Start -->
    <div class="container-fluid pb-5">
        <section id="billboard" class="border-bottom py-3 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <h1 class="fs-1 text-center mt-4">
                        CART
                    </h1>
                </div>
            </div>
        </section>

        <div class="row px-xl-5">
            {{-- Cart Table --}}
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table text-center mb-0" id="productTable">
                    <thead class="text-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>

                    <tbody class="align-middle">
                        {{-- Logged-in User Cart --}}
                        @if (Auth::check())

                            @if (count($cart) != 0)
                                @foreach ($cart as $item)
                                    <tr data-cart-id="{{ $item->cart_id }}">
                                        {{-- Product Image --}}
                                        <td class="align-middle text-center">
                                            <img src="{{ asset('productImage/' . $item->image) }}" alt="Product Image"
                                                class="rounded"
                                                style="
                                                    width: 100px;
                                                    height: 100px;
                                                    object-fit: contain;
                                                    border-radius: 8px;
                                                " />
                                        </td>

                                        {{-- Product Name --}}
                                        <td>
                                            {{ $item->name }}
                                        </td>

                                        {{-- Price --}}
                                        <td class="align-middle price">
                                            {{ number_format($item->price) }}
                                            MMK
                                        </td>

                                        {{-- Quantity --}}
                                        <td style="vertical-align: middle;">
                                            <div class="input-group cart-quantity" style="width: 100px;">
                                                {{-- Minus --}}
                                                <div class="input-group-btn">

                                                    <button type="button"
                                                        class="btn btn-sm btn-minus cart-qty-btn rounded-circle bg-light border">
                                                        <i class="fa fa-minus"></i>
                                                    </button>

                                                </div>

                                                {{-- Input --}}
                                                <input type="text"
                                                    class="form-control qty form-control-sm text-center border-0"
                                                    value="{{ $item->qty }}" data-cart-id="{{ $item->cart_id }}"
                                                    readonly />

                                                {{-- Plus --}}
                                                <div class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-sm btn-plus cart-qty-btn rounded-circle bg-light border">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Total --}}
                                        <td class="align-middle total">
                                            {{ number_format($item->price * $item->qty) }}
                                            MMK
                                        </td>

                                        {{-- Remove --}}
                                        <td class="align-middle">

                                            <input type="hidden" name="cartId" class="cartId"
                                                value="{{ $item->cart_id }}" />

                                            <input type="hidden" class="userId" value="{{ Auth::user()->id }}" />

                                            <input type="hidden" class="productId" value="{{ $item->product_id }}" />

                                            <button type="button" class="btn btn-remove btn-sm btn-primary rounded">
                                                <i class="fa fa-times"></i>
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="p-5">
                                        <h5 class="text-muted text-center">
                                            No items in cart
                                        </h5>

                                        <a href="{{ route('user#shop') }}" class="btn btn-outline-dark mt-3">
                                            Return to shop
                                        </a>
                                    </td>
                                </tr>
                            @endif

                            {{-- Guest Cart --}}
                        @else
                            @if (count($cart) > 0)
                                @foreach ($cart as $id => $item)
                                    <tr data-product-id="{{ $id }}" class="guest-cart-item">
                                        {{-- Product Image --}}
                                        <td class="align-middle text-center">
                                            <img src="{{ asset('productImage/' . $item['image']) }}" alt="Product Image"
                                                class="rounded"
                                                style="
                                                    width: 100px;
                                                    height: 100px;
                                                    object-fit: contain;
                                                    border-radius: 8px;
                                                " />
                                        </td>

                                        {{-- Product Name --}}
                                        <td>
                                            {{ $item['name'] }}
                                        </td>

                                        {{-- Price --}}
                                        <td class="align-middle price">

                                            {{ number_format($item['price']) }}
                                            MMK
                                        </td>

                                        {{-- Quantity --}}
                                        <td style="vertical-align: middle;">

                                            <div class="input-group cart-quantity" style="width: 100px;">

                                                {{-- Minus --}}
                                                <div class="input-group-btn">

                                                    <button type="button"
                                                        class="btn btn-sm btn-minus cart-qty-btn guest-qty-btn rounded-circle bg-light border">
                                                        <i class="fa fa-minus"></i>
                                                    </button>

                                                </div>

                                                {{-- Input --}}
                                                <input type="text"
                                                    class="form-control qty form-control-sm text-center border-0 guest-qty"
                                                    value="{{ $item['quantity'] }}" data-product-id="{{ $id }}"
                                                    readonly />

                                                {{-- Plus --}}
                                                <div class="input-group-btn">
                                                    <button type="button"
                                                        class="btn btn-sm btn-plus cart-qty-btn guest-qty-btn rounded-circle bg-light border">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Total --}}
                                        <td class="align-middle total">
                                            {{ number_format($item['price'] * $item['quantity']) }}
                                            MMK
                                        </td>

                                        {{-- Remove --}}
                                        <td class="align-middle">

                                            <button type="button"
                                                class="btn btn-remove btn-sm btn-primary rounded guest-remove"
                                                data-product-id="{{ $id }}">
                                                <i class="fa fa-times"></i>
                                            </button>

                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>

                                    <td colspan="7" class="p-5">

                                        <h5 class="text-muted text-center">
                                            No items in cart
                                        </h5>

                                        <a href="{{ route('user#shop') }}" class="btn btn-outline-dark mt-3">
                                            Return to shop
                                        </a>

                                    </td>

                                </tr>
                            @endif

                        @endif

                    </tbody>

                </table>

            </div>

            {{-- Cart Summary --}}
            <div class="col-lg-4 mt-5">

                <div class="card border-0 mb-5">

                    <div class="card-header bg-primary border-0">

                        <h4 class="font-weight-semi-bold text-white m-0">
                            Cart Summary
                        </h4>

                    </div>


                    <div class="card-body">

                        {{-- Subtotal --}}
                        <div class="d-flex justify-content-between mb-3 pt-1">

                            <h6 class="font-weight-medium">
                                Subtotal
                            </h6>

                            <h6 class="font-weight-medium" id="subtotal">
                                {{ number_format($total) }}
                                MMK
                            </h6>

                        </div>


                        {{-- Delivery --}}
                        <div class="d-flex justify-content-between">

                            <h6 class="font-weight-medium">
                                Delivery
                            </h6>

                            <h6 class="font-weight-medium">
                                5,000 MMK
                            </h6>

                        </div>

                    </div>


                    <div class="card-footer border-secondary bg-transparent">

                        {{-- Final Total --}}
                        <div class="d-flex justify-content-between mt-2">

                            <h5 class="font-weight-bold">
                                Total
                            </h5>

                            <h5 class="font-weight-bold" id="finaltotal">
                                {{ number_format($total + 5000) }}
                                MMK
                            </h5>

                        </div>


                        {{-- Checkout --}}
                        @if (count($cart) != 0)
                            @auth

                                <button type="button" id="btn-checkout" class="btn btn-block rounded btn-primary my-3 p-2">
                                    Proceed To Checkout
                                </button>
                            @else
                                <button type="button" class="btn btn-block rounded btn-secondary my-3 p-2"
                                    onclick="AuthHelper.showLoginPrompt('checkout')">
                                    Login to Checkout
                                </button>

                            @endauth
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
    <!-- Cart End -->

@endsection
