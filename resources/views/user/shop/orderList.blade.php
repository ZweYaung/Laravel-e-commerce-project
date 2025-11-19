@extends('user.layouts.master')

@section('content')
    <div class="container" style="margin-bottom: 150px">
        <section id="billboard" class="border-bottom py-3 mb-3">
            <div class="container">
                <div class="row justify-content-center">
                    <h1 class="fs-1 text-center mt-4">
                        ORDER LIST
                    </h1>
                </div>
            </div>
        </section>
        <div class="row">
            <table class="table table-hover shadow-sm ">
                <thead class="text-dark">
                    <tr>
                        <th>Date</th>
                        <th>Order Code</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>

                    @if (count($orderList) != 0)
                        @foreach ($orderList as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                <td><a class="btn-link fs-6"
                                        href="{{ route('user#orderDetails', $item->order_code) }}">{{ $item->order_code }}</a>
                                </td>
                                <td>
                                    @if ($item->status == 0)
                                        <div class="btn me-2 btn-sm rounded shadow-sm"><i
                                                class="fa-solid fa-spinner text-primary"></i>
                                        </div>Pending
                                    @elseif($item->status == 1)
                                        <div class="btn me-2 btn-sm rounded shadow-sm"><i
                                                class="fa-solid fa-check text-success"></i>
                                        </div>Accepted
                                    @else
                                        <div class="btn me-2 btn-sm rounded shadow-sm"><i
                                                class="fa-solid fa-xmark text-danger"></i>
                                        </div>Rejected
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-muted text-center">You have not made any order!</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <span class="d-flex justify-content-center">{{ $orderList->links() }}</span>
        </div>
    </div>
@endsection
