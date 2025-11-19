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
                        @if (count($cart) != 0)
                            @foreach ($cart as $item)
                                <tr>


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
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                    id="btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text"
                                                class="form-control qty form-control-sm text-center border-0"
                                                value="{{ $item->qty }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                    id="btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="align-middle total">{{ number_format($item->price * $item->qty) }} MMK</td>

                                    <td class="align-middle">
                                        <input type="hidden" name="cartId" class="cartId" value="{{ $item->cart_id }}">
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
                                    <a href="{{ route('user#shop') }}" class="btn btn-outline-dark mt-3">Return to shop</a>
                                </td>
                            </tr>
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
                            <button type="button" id="btn-checkout" class="btn btn-block rounded btn-primary my-3 p-2">
                                Proceed To Checkout
                            </button>
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

            $('.btn-minus').click(function() {
                countCalculation(this);
                finalTotalCalculation()

            });

            $('.btn-plus').click(function() {
                countCalculation(this);
                finalTotalCalculation()
            });

            function countCalculation(event) {
                parentNode = $(event).parents("tr");
                price = parentNode.find(".price").text().replace(/[^\d.]/g, "");
                qty = parentNode.find(".qty").val();
                price = parseInt(price);
                qty = parseInt(qty);

                total = price * qty

                parentNode.find(".total").text(formatNumber(total) + " MMK");
            }

            //format numbers with commas
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            function finalTotalCalculation() {
                total = 0;

                $("#productTable tbody tr").each(function(index, item) {
                    total += parseInt($(item).find(".total").text().replace(/[^\d.]/g, ""));
                })

                $("#subtotal").html(formatNumber(total) + " MMK");
                $("#finaltotal").html(formatNumber(total + 5000) + " MMK");

            }

            $(".btn-remove").click(function() {
                parentNode = $(this).parents("tr");
                cartId = parentNode.find(".cartId").val();

                removeData = {
                    'cartId': cartId
                };

                $.ajax({
                    type: 'get',
                    url: '/user/remove/cart',
                    data: removeData,
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.reload() : "";
                    },
                    error: function() {
                        console.log("Opps! Something went wrong!")
                    }
                })
            })

            $('#btn-checkout').click(function() {
                orderList = [];
                userId = $('.userId').val();
                orderCode = "COS-209-" + Math.floor(Math.random() * 10000000000);

                $('#productTable  tbody tr').each(function(index, row) {
                    productId = $(row).find('.productId').val();
                    qty = $(row).find('.qty').val();
                    finalTotal = $('#finaltotal').text().replace(/[^\d.]/g, "");

                    orderList.push({
                        'product_id': productId,
                        'user_id': userId,
                        'count': qty,
                        'status': 0,
                        'order_code': orderCode,
                        'totalAmt': finalTotal
                    });
                })

                $.ajax({
                    type: 'get',
                    url: '/user/tempStorage',
                    data: Object.assign({}, orderList),
                    dataType: 'json',
                    success: function(res) {
                        res.status == 'success' ? location.href = '/user/checkOutPage' :
                            location
                            .reload();
                    }
                })

            })

        })
    </script>
@endsection
