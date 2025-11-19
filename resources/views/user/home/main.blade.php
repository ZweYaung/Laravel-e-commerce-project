@extends('user.layouts.master')

@section('content')
    <!-- Home -->
    <section id="billboard" class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="section-title text-center mt-4" data-aos="fade-up">
                    New Collections
                </h1>
                <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
                    <p>
                        Discover our latest arrivals, where modern style meets unbeatable comfort.
                        From versatile everyday wear to statement pieces, our new collection is
                        designed to keep you ahead of the trends. Explore fresh designs, premium
                        fabrics, and timeless styles – all crafted to elevate your wardrobe this
                        season!
                    </p>
                </div>
            </div>
            <div class="row mt-5">
                <div class="swiper main-swiper py-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="swiper-wrapper d-flex border-animation-left">
                        @foreach ($newArrivals as $item)
                            <div class="swiper-slide">
                                <div class="banner-item image-zoom-effect">
                                    <div class="image-holder" style="height: 500px; overflow: hidden;">
                                        <a href="{{ route('shop#productDetails', $item->id) }}">
                                            <img src="{{ asset('productImage/' . $item->image) }}" alt="product"
                                                class="img-fluid w-100 object-fit-cover" style="height: 100%;">
                                        </a>
                                    </div>

                                    <div class="banner-content py-4">
                                        <h5 class="element-title text-uppercase">
                                            <a href="{{ route('shop#productDetails', $item->id) }}"
                                                class="item-anchor">{{ $item->name }}</a>
                                        </h5>
                                        <p>
                                            {{ Str::limit($item->description, 70, '...') }}
                                        </p>
                                        <div class="btn-left">
                                            <a href="{{ route('shop#productDetails', $item->id) }}"
                                                class="btn-link fs-6 text-uppercase item-anchor text-decoration-none">Discover
                                                Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination d-sm-none"></div>
                </div>
                <div class="icon-arrow icon-arrow-left d-none d-md-inline-flex align-items-center justify-content-center p-2"
                    style="width: 100px; height: 100px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>

                <div class="icon-arrow icon-arrow-right d-none d-md-inline-flex align-items-center justify-content-center p-2"
                    style="width: 100px; height: 100px;">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>


            </div>
        </div>
    </section>

    <section class="features py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="0">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use mdink:href="#calendar"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">
                            Book An Appointment
                        </h4>
                    </div>
                </div>
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="300">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use xlink:href="#shopping-bag"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">
                            Pick up in store
                        </h4>
                    </div>
                </div>
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="600">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use xlink:href="#gift"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">
                            Special packaging
                        </h4>
                    </div>
                </div>
                <div class="col-md-3 text-center" data-aos="fade-in" data-aos-delay="900">
                    <div class="py-5">
                        <svg width="38" height="38" viewBox="0 0 24 24">
                            <use xlink:href="#arrow-cycle"></use>
                        </svg>
                        <h4 class="element-title text-capitalize my-3">
                            free global returns
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="new-arrival" class="new-arrival product-carousel py-5 position-relative overflow-hidden">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
                <h4 class="text-uppercase">Our New Arrivals</h4>
                <a href="{{ route('user#shop') }}" class="btn-link">View All Products</a>
            </div>
            <div class="swiper product-swiper open-up" data-aos="zoom-out">
                <div class="swiper-wrapper d-flex">
                    @foreach ($newArrivals as $item)
                        <div class="swiper-slide">
                            <div class="product-item image-zoom-effect link-effect">
                                <div class="image-holder position-relative">
                                    <a href="{{ route('shop#productDetails', $item->id) }}">
                                        <img src="{{ asset('productImage/' . $item->image) }}" alt="categories"
                                            class="product-image img-fluid w-100 object-fit-cover"
                                            style="height: 400px; overflow: hidden;" />
                                    </a>
                                    @php
                                        $isInWishlist = $wishlistItems->firstWhere('product_id', $item->id);
                                    @endphp


                                    @if ($isInWishlist)
                                        <a href="{{ route('wishlist#remove', $isInWishlist->id) }}"
                                            title="Remove from Wishlist" class="btn-icon btn-wishlist"><i
                                                class="fa-solid fa-heart"></i></a>
                                    @else
                                        <a href="{{ route('wishlist#add', $item->id) }}" title="Add to Wishlist"
                                            class="btn-icon btn-wishlist">
                                            <i class="fa-regular fa-heart"></i>
                                        </a>
                                    @endif
                                    <div class="product-content">
                                        <h5 class="element-title text-uppercase fs-5 mt-3">
                                            <a
                                                href="{{ route('shop#productDetails', $item->id) }}">{{ $item->name }}</a>
                                        </h5>
                                        <a href="{{ route('user#addToCartGet', $item->id) }}"
                                            class="text-decoration-none"
                                            data-after="Add to cart"><span>{{ number_format($item->price) }}
                                                MMK</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="icon-arrow icon-arrow-left  d-none d-xxl-inline-flex align-items-center justify-content-center p-2"
                style="width: 70px; height: 70px;">
                <i class="fa-solid fa-arrow-left"></i>
            </div>

            <div class="icon-arrow icon-arrow-right  d-none d-xxl-inline-flex align-items-center justify-content-center p-2"
                style="width: 70px; height: 70px;">
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </div>
    </section>

    <section id="best-sellers" class="best-sellers product-carousel py-5 position-relative overflow-hidden">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
                <h4 class="text-uppercase">Best Selling Items</h4>
                <a href="{{ route('user#shop') }}" class="btn-link">View All Products</a>
            </div>
            <div class="swiper product-swiper open-up" data-aos="zoom-out">
                <div class="swiper-wrapper d-flex">
                    @foreach ($newArrivals as $item)
                        <div class="swiper-slide">
                            <div class="product-item image-zoom-effect link-effect">
                                <div class="image-holder position-relative">
                                    <a href="{{ route('shop#productDetails', $item->id) }}">
                                        <img src="{{ asset('productImage/' . $item->image) }}" alt="categories"
                                            class="product-image img-fluid w-100 object-fit-cover"
                                            style="height: 400px; overflow: hidden;" />
                                    </a>
                                    @php
                                        $isInWishlist = $wishlistItems->firstWhere('product_id', $item->id);
                                    @endphp


                                    @if ($isInWishlist)
                                        <a href="{{ route('wishlist#remove', $isInWishlist->id) }}"
                                            title="Remove from Wishlist" class="btn-icon btn-wishlist"><i
                                                class="fa-solid fa-heart"></i></a>
                                    @else
                                        <a href="{{ route('wishlist#add', $item->id) }}" title="Add to Wishlist"
                                            class="btn-icon btn-wishlist">
                                            <i class="fa-regular fa-heart"></i>
                                        </a>
                                    @endif
                                    <div class="product-content">
                                        <h5 class="element-title text-uppercase fs-5 mt-3">
                                            <a
                                                href="{{ route('shop#productDetails', $item->id) }}">{{ $item->name }}</a>
                                        </h5>
                                        <a href="{{ route('user#addToCartGet', $item->id) }}"
                                            class="text-decoration-none"
                                            data-after="Add to cart"><span>{{ number_format($item->price) }}
                                                MMK</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="icon-arrow icon-arrow-left  d-none d-xxl-inline-flex align-items-center justify-content-center p-2"
                style="width: 70px; height: 70px;">
                <i class="fa-solid fa-arrow-left"></i>
            </div>

            <div class="icon-arrow icon-arrow-right  d-none d-xxl-inline-flex align-items-center justify-content-center p-2"
                style="width: 70px; height: 70px;">
                <i class="fa-solid fa-arrow-right"></i>
            </div>
        </div>
    </section>
@endsection
