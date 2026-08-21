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
                        @if (Auth::check())
                            {{-- Logged-in user cart --}}
                            @if (count($cart) != 0)
                                @foreach ($cart as $item)
                                    <tr data-cart-id="{{ $item->cart_id }}">
                                        <td class="align-middle text-center">
                                            <img src="{{ asset('productImage/' . $item->image) }}" alt="Product Image"
                                                class="rounded"
                                                style="width: 100px; height: 100px; object-fit: contain; border-radius: 8px;" />
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td class="align-middle price">{{ number_format($item->price) }} MMK</td>
                                        <td style="vertical-align: middle;">
                                            <div class="input-group quantity" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text"
                                                    class="form-control qty form-control-sm text-center border-0"
                                                    value="{{ $item->qty }}" data-cart-id="{{ $item->cart_id }}" />
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle total">{{ number_format($item->price * $item->qty) }} MMK
                                        </td>
                                        <td class="align-middle">
                                            <input type="hidden" name="cartId" class="cartId"
                                                value="{{ $item->cart_id }}">
                                            <input type="hidden" class="userId" value="{{ Auth::user()->id }}">
                                            <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                            <button class="btn btn-remove btn-sm btn-primary rounded">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="p-5">
                                        <h5 class="text-muted text-center">No items in cart</h5>
                                        <a href="{{ route('user#shop') }}" class="btn btn-outline-dark mt-3">Return to
                                            shop</a>
                                    </td>
                                </tr>
                            @endif
                        @else
                            {{-- Guest cart from session --}}
                            @if (count($cart) > 0)
                                @foreach ($cart as $id => $item)
                                    <tr data-product-id="{{ $id }}" class="guest-cart-item">
                                        <td class="align-middle text-center">
                                            <img src="{{ asset('productImage/' . $item['image']) }}" alt="Product Image"
                                                class="rounded"
                                                style="width: 100px; height: 100px; object-fit: contain; border-radius: 8px;" />
                                        </td>
                                        <td>{{ $item['name'] }}</td>
                                        <td class="align-middle price">{{ number_format($item['price']) }} MMK</td>
                                        <td style="vertical-align: middle;">
                                            <div class="input-group quantity" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button
                                                        class="btn btn-sm btn-minus rounded-circle bg-light border guest-qty-btn">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text"
                                                    class="form-control qty form-control-sm text-center border-0 guest-qty"
                                                    value="{{ $item['quantity'] }}"
                                                    data-product-id="{{ $id }}" />
                                                <div class="input-group-btn">
                                                    <button
                                                        class="btn btn-sm btn-plus rounded-circle bg-light border guest-qty-btn">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle total">
                                            {{ number_format($item['price'] * $item['quantity']) }} MMK</td>
                                        <td class="align-middle">
                                            <button class="btn btn-remove btn-sm btn-primary rounded guest-remove"
                                                data-product-id="{{ $id }}">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="p-5">
                                        <h5 class="text-muted text-center">No items in cart</h5>
                                        <a href="{{ route('user#shop') }}" class="btn btn-outline-dark mt-3">Return to
                                            shop</a>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4 mt-5">
                <div class="card border-0 mb-5">
                    <div class="card-header bg-primary border-0">
                        <h4 class="font-weight-semi-bold text-white m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium" id="subtotal">{{ number_format($total) }} MMK</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">5,000 MMK</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="finaltotal">{{ number_format($total + 5000) }} MMK</h5>
                        </div>
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

@section('js-script')
    <script>
        $(document).ready(function() {

            // Helper functions
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function updateCartTotals() {
                let total = 0;
                $("#productTable tbody tr").each(function(index, item) {
                    let priceText = $(item).find(".price").text().replace(/[^\d.]/g, "");
                    let qty = parseInt($(item).find(".qty").val()) || 0;
                    let price = parseInt(priceText) || 0;
                    let itemTotal = price * qty;
                    $(item).find(".total").text(formatNumber(itemTotal) + " MMK");
                    total += itemTotal;
                });
                $("#subtotal").html(formatNumber(total) + " MMK");
                $("#finaltotal").html(formatNumber(total + 5000) + " MMK");
            }

            // Logged-in user cart actions

            // Quantity change (minus/plus)
            $(document).on('click', '.btn-minus, .btn-plus', function() {
                let parentTr = $(this).closest('tr');
                let qtyInput = parentTr.find('.qty');
                let currentVal = parseInt(qtyInput.val()) || 1;
                if ($(this).hasClass('btn-minus')) {
                    if (currentVal > 1) qtyInput.val(currentVal - 1);
                } else {
                    qtyInput.val(currentVal + 1);
                }
                updateCartTotals();

                let cartId = parentTr.data('cart-id');
                if (cartId) {
                    let newQty = parseInt(qtyInput.val());
                    $.ajax({
                        type: 'PATCH',
                        url: '/user/cart/update/' + cartId,
                        data: {
                            quantity: newQty
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
                        },
                        success: function(res) {
                            if (res.success) {
                                AuthHelper.updateCartCount(res.cartCount);
                            }
                        },
                        error: function() {
                            AuthHelper.showToast('Error updating quantity', 'danger');
                        }
                    });
                }
            });

            // Remove item (logged-in) - NO CONFIRMATION
            $(document).on('click', '.btn-remove', function() {
                let parentTr = $(this).closest('tr');
                let cartId = parentTr.find('.cartId').val();
                if (!cartId) return;

                // Show a loading state on the button
                let btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                    type: 'get',
                    url: '/user/remove/cart',
                    data: {
                        cartId: cartId
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status == 'success') {
                            parentTr.fadeOut(300, function() {
                                $(this).remove();
                                updateCartTotals();
                                AuthHelper.updateCartCount(res.cartCount || 0);
                                AuthHelper.showToast('Item removed', 'success');
                                if ($("#productTable tbody tr").length === 0) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-times"></i>');
                        AuthHelper.showToast('Error removing item', 'danger');
                    }
                });
            });

            // Guest cart actions

            // Quantity change for guest
            $(document).on('click', '.guest-qty-btn', function() {
                let parentTr = $(this).closest('tr');
                let qtyInput = parentTr.find('.guest-qty');
                let currentVal = parseInt(qtyInput.val()) || 1;
                if ($(this).hasClass('btn-minus')) {
                    if (currentVal > 1) qtyInput.val(currentVal - 1);
                } else {
                    qtyInput.val(currentVal + 1);
                }
                updateCartTotals();

                let productId = qtyInput.data('product-id');
                let newQty = parseInt(qtyInput.val());
                $.ajax({
                    type: 'PATCH',
                    url: '/user/guest/cart/update',
                    data: {
                        productId: productId,
                        quantity: newQty
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(res) {
                        if (res.success) {
                            AuthHelper.updateCartCount(res.cartCount);
                        }
                    },
                    error: function() {
                        AuthHelper.showToast('Error updating quantity', 'danger');
                    }
                });
            });

            // Remove guest item - NO CONFIRMATION
            $(document).on('click', '.guest-remove', function() {
                let productId = $(this).data('product-id');
                let btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                    type: 'DELETE',
                    url: '/user/guest/cart/remove',
                    data: {
                        productId: productId
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(res) {
                        if (res.success) {
                            let row = $(`tr[data-product-id="${productId}"]`);
                            row.fadeOut(300, function() {
                                $(this).remove();
                                updateCartTotals();
                                AuthHelper.updateCartCount(res.cartCount);
                                AuthHelper.showToast('Item removed', 'success');
                                if ($("#productTable tbody tr").length === 0) {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-times"></i>');
                        AuthHelper.showToast('Error removing item', 'danger');
                    }
                });
            });

            // Checkout
            $('#btn-checkout').click(function() {
                let orderList = [];
                let userId = $('.userId').val();
                let orderCode = "COS-209-" + Math.floor(Math.random() * 10000000000);

                $('#productTable tbody tr').each(function(index, row) {
                    let productId = $(row).find('.productId').val();
                    let qty = $(row).find('.qty').val();
                    let finalTotal = $('#finaltotal').text().replace(/[^\d.]/g, "");

                    orderList.push({
                        'product_id': productId,
                        'user_id': userId,
                        'count': qty,
                        'status': 0,
                        'order_code': orderCode,
                        'totalAmt': finalTotal
                    });
                });

                $.ajax({
                    type: 'get',
                    url: '/user/tempStorage',
                    data: Object.assign({}, orderList),
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.href = '/user/checkOutPage' :
                            location.reload();
                    }
                });
            });

            // Initial totals
            updateCartTotals();
        });
    </script>
@endsection
