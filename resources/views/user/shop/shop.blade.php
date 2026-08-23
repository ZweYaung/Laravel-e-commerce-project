@extends('user.layouts.master')

@section('content')
    <section id="billboard" class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="section-title text-center mt-4" data-aos="fade-up">SHOP</h1>
                <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
                    <p>BROWSE AS YOU WANT, BUY AS YOU WISH</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid pt-5">
        <div class="row px-xl-5 d-flex justify-content-center">
            <div class="col-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="{{ route('user#shop') }}" method="get" class="d-flex align-items-center"
                                role="search">
                                <a href="{{ route('user#shop') }}" class="btn"><i
                                        class="fa-solid fa-arrows-rotate align-middle"></i></a>
                                <input class="form-control me-2" value="{{ request('searchKey') }}" name="searchKey"
                                    type="search" placeholder="Search" aria-label="Search" />
                                <button class="btn btn-outline-dark rounded" type="submit">Search</button>
                            </form>

                            <li class="dropdown">
                                <a class="dropdown-toggle btn" href="#" id="dropdownHome" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    @php
                                        $sortText = 'Sort by';
                                        if ($action == 'oldest') {
                                            $sortText = 'Oldest';
                                        } elseif ($action == 'bestRating') {
                                            $sortText = 'Best Rating';
                                        } elseif ($action == 'priceLowToHigh') {
                                            $sortText = 'Price: Low to High';
                                        } elseif ($action == 'priceHighToLow') {
                                            $sortText = 'Price: High to Low';
                                        }
                                    @endphp
                                    {{ $sortText }}
                                </a>
                                <ul class="dropdown-menu list-unstyled" aria-labelledby="dropdownHome">
                                    <li><a href="{{ route('user#shop') }}" class="dropdown-item item-anchor">Default -
                                            Latest</a></li>
                                    <li><a href="{{ route('user#shop', 'oldest') }}"
                                            class="dropdown-item item-anchor">Oldest</a></li>
                                    <li><a href="{{ route('user#shop', 'priceLowToHigh') }}"
                                            class="dropdown-item item-anchor">Price: Low to High</a></li>
                                    <li><a href="{{ route('user#shop', 'priceHighToLow') }}"
                                            class="dropdown-item item-anchor">Price: High to Low</a></li>
                                </ul>
                            </li>
                        </div>
                    </div>

                    @if (count($products) != 0)
                        @foreach ($products as $item)
                            <div class="col-lg-3 col-md-6 col-sm-12 pb-1 mb-5">
                                <div class="card product-item border-0 mb-4 image-zoom-effect d-flex flex-column h-100">
                                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0"
                                        style="height: 400px;">
                                        <a href="{{ route('shop#productDetails', $item->id) }}">
                                            <img class="img-fluid w-100 h-100"
                                                src="{{ asset('productImage/' . $item->image) }}" alt="{{ $item->name }}"
                                                style="object-fit: cover;">
                                        </a>

                                        @php
                                            $isInWishlist =
                                                Auth::check() && $wishlistItems->firstWhere('product_id', $item->id);
                                        @endphp

                                        {{-- Wishlist toggle – global handler will check auth --}}
                                        <a href="#"
                                            title="{{ $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                                            class="btn-icon btn-wishlist wishlist-toggle"
                                            data-product-id="{{ $item->id }}">
                                            <i class="{{ $isInWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                        </a>
                                    </div>

                                    <div class="card-body border-left border-right text-center p-2">
                                        <h6 class="mb-2" style="white-space: normal; word-wrap: break-word;">
                                            {{ $item->name }}</h6>
                                        <div class="d-flex justify-content-center">
                                            <h6 class="m-0">{{ number_format($item->price) }} MMK</h6>
                                        </div>
                                    </div>

                                    <div class="card-footer d-flex justify-content-center bg-light border mt-auto">
                                        {{-- Add to Cart – global handler will check auth --}}
                                        <button class="btn btn-sm text-dark p-0 add-to-cart-btn"
                                            data-product-id="{{ $item->id }}" data-qty="1">
                                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">
                                <h5 class="text-muted text-center">Found nothing!</h5>
                            </td>
                        </tr>
                    @endif
                    <span class="d-flex justify-content-center">{{ $products->links() }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
