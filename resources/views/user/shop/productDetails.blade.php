@extends('user.layouts.master')

@section('content')
    <div class="container-fluid py-5">
        <div class="row d-flex justify-content-between align-items-center p-3">
            <div class="col-auto">
                <a href="{{ route('user#shop') }}" class="btn-link fs-5 text-dark">
                    Back
                </a>
            </div>
        </div>

        <div class="row px-xl-5 d-flex justify-content-around mb-3">

            {{-- Product Image --}}
            <div class="col-lg-5 col-md-6 col-sm-12 pb-4 border-end">
                <div class="product-img position-relative object-fit-fill overflow-hidden p-0 text-center">
                    <img src="{{ asset('productImage/' . $product->image) }}" alt="Image" class="img-fluid rounded"
                        style="max-height: 500px;" />
                </div>
            </div>

            {{-- Product Information --}}
            <div class="col-lg-6 pb-5">

                <h3 class="font-weight-semi-bold">
                    {{ $product->name }}
                </h3>

                {{-- Rating --}}
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">

                        @for ($i = 1; $i <= $stars; $i++)
                            <i class="fas fa-star"></i>
                        @endfor

                        @for ($j = $stars + 1; $j <= 5; $j++)
                            <i class="far fa-star"></i>
                        @endfor
                    </div>

                    <small class="pt-1">
                        ({{ count($comments) > 0 ? count($comments) : 0 }} Reviews)
                    </small>
                </div>


                {{-- Price --}}
                <h3 class="font-weight-semi-bold mb-4">
                    {{ number_format($product->price) }} MMK
                </h3>


                {{-- Quantity / Cart / Wishlist --}}
                <div class="d-flex align-items-center mb-4">

                    {{-- Quantity --}}
                    <div class="input-group product-quantity" style="width: 100px">

                        <div class="input-group-btn">
                            <button type="button" class="btn btn-sm detail-minus rounded-circle bg-light border">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>


                        <input type="text" id="product-qty" class="form-control form-control-sm text-center border-0"
                            value="1" readonly />


                        <div class="input-group-btn">
                            <button type="button" class="btn btn-sm detail-plus rounded-circle bg-light border">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>

                    </div>


                    @php
                        $isInWishlist = Auth::check() && $wishlistItems->firstWhere('product_id', $product->id);
                    @endphp


                    {{-- Add to Cart --}}
                    <button type="button" class="btn btn-primary rounded px-4 py-2 mb-4 ms-3 add-to-cart-detail"
                        data-product-id="{{ $product->id }}">
                        Add to cart
                    </button>


                    {{-- Wishlist --}}
                    <button type="button" class="btn btn-outline-danger rounded px-4 py-2 mb-4 ms-2 wishlist-toggle-detail"
                        data-product-id="{{ $product->id }}"
                        title="{{ $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                        <i class="{{ $isInWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                    </button>

                </div>


                {{-- Share --}}
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">
                        Share on:
                    </p>

                    <div class="d-inline-flex">

                        <a class="text-dark px-2" href="#">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a class="text-dark px-2" href="#">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                        <a class="text-dark px-2" href="#">
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                        <a class="text-dark px-2" href="#">
                            <i class="fab fa-pinterest"></i>
                        </a>

                    </div>
                </div>

            </div>

        </div>

        {{-- Product Description / Reviews --}}
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-bs-toggle="tab" href="#tab-pane-1">
                        Description
                    </a>

                    <a class="nav-item nav-link" data-bs-toggle="tab" href="#tab-pane-2">
                        Reviews
                        ({{ count($comments) > 0 ? count($comments) : 0 }})
                    </a>
                </div>


                <div class="tab-content">
                    {{-- Description --}}
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">
                            Product Description
                        </h4>

                        <p>
                            {{ $product->description }}
                        </p>
                    </div>

                    {{-- Reviews --}}
                    <div class="tab-pane fade" id="tab-pane-2">
                        <div class="row">
                            {{-- Existing Reviews --}}
                            <div class="col-md-6">
                                <h4 class="mb-4">
                                    {{ count($comments) > 0 ? count($comments) : 0 }}
                                    review for
                                    "{{ $product->name }}"
                                </h4>
                                @foreach ($comments as $item)
                                    <div class="media mb-4">
                                        <img src="{{ asset('profile_pic/' . $item->image) }}" alt="Image"
                                            class="img-fluid mr-3 mt-1 mb-2 rounded-circle" style="width: 35px" />
                                        <div class="media-body">
                                            <h6>
                                                {{ $item->name }}
                                                <small>
                                                    -
                                                    <i>
                                                        {{ $item->created }}
                                                    </i>
                                                </small>
                                            </h6>
                                            <div class="text-primary mb-2">
                                                @if ($item->rating != 0)
                                                    @for ($i = 1; $i <= $item->rating; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor

                                                    @for ($j = $item->rating + 1; $j <= 5; $j++)
                                                        <i class="far fa-star"></i>
                                                    @endfor
                                                @endif

                                            </div>
                                            <p>
                                                {{ $item->message }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            {{-- Review Form --}}
                            <div class="col-md-6">

                                <h4 class="mb-4">
                                    Leave a review
                                </h4>

                                <div class="border rounded p-3 bg-light">

                                    <label for="rating">
                                        Rating *
                                    </label>

                                    @auth
                                        <form id="ratingForm" class="d-flex col-lg-5 justify-content-between">
                                            @csrf
                                            <div class="rating-css">
                                                <div class="star-icon">
                                                    <input type="hidden" name="productId" value="{{ $product->id }}" />
                                                    @if ($userRating == 0)
                                                        <input type="radio" value="1" name="productRating" checked
                                                            id="rating1" />

                                                        <label for="rating1" class="fa fa-star"></label>


                                                        <input type="radio" value="2" name="productRating"
                                                            id="rating2" />

                                                        <label for="rating2" class="fa fa-star"></label>


                                                        <input type="radio" value="3" name="productRating"
                                                            id="rating3" />

                                                        <label for="rating3" class="fa fa-star"></label>


                                                        <input type="radio" value="4" name="productRating"
                                                            id="rating4" />

                                                        <label for="rating4" class="fa fa-star"></label>


                                                        <input type="radio" value="5" name="productRating"
                                                            id="rating5" />

                                                        <label for="rating5" class="fa fa-star"></label>
                                                    @else
                                                        @for ($i = 1; $i <= $userRating; $i++)
                                                            <input type="radio" value="{{ $i }}"
                                                                name="productRating" checked
                                                                id="rating{{ $i }}" />

                                                            <label for="rating{{ $i }}"
                                                                class="fa fa-star"></label>
                                                        @endfor


                                                        @for ($j = $userRating + 1; $j <= 5; $j++)
                                                            <input type="radio" value="{{ $j }}"
                                                                name="productRating" id="rating{{ $j }}" />

                                                            <label for="rating{{ $j }}"
                                                                class="fa fa-star"></label>
                                                        @endfor
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center">

                                                <input type="submit" value="Rate"
                                                    class="btn btn-sm btn-primary px-3 rounded" />

                                            </div>
                                        </form>
                                    @else
                                        <div class="alert alert-info">

                                            <a href="{{ route('login') }}?redirect={{ url()->current() }}">
                                                Log in
                                            </a>

                                            to rate this product.

                                        </div>

                                    @endauth


                                    {{-- Comment Form --}}
                                    @auth

                                        <form id="commentForm" method="post">

                                            @csrf


                                            <input type="hidden" name="productId" value="{{ $product->id }}" />


                                            <div class="form-group">

                                                <label for="message">
                                                    Your Review *
                                                </label>


                                                <textarea id="message" name="message" cols="30" rows="5"
                                                    class="form-control @error('message') is-invalid @enderror"></textarea>


                                                @error('message')
                                                    <small class="invalid-feedback">
                                                        {{ $message }}
                                                    </small>
                                                @enderror

                                            </div>


                                            <div class="form-group mt-2">

                                                <input type="submit" value="Submit" class="btn btn-primary px-3 rounded" />

                                            </div>

                                        </form>
                                    @else
                                        <div class="alert alert-info mt-3">

                                            <a href="{{ route('login') }}?redirect={{ url()->current() }}">
                                                Log in
                                            </a>

                                            to post a review.

                                        </div>

                                    @endauth

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Related Products --}}
        <section id="related-products" class="related-products product-carousel py-5 position-relative overflow-hidden">

            <div class="container">

                <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">

                    <h4 class="text-uppercase">
                        You May Also Like
                    </h4>

                    <a href="{{ route('user#shop') }}" class="btn-link">
                        View All Products
                    </a>

                </div>


                <div class="swiper product-swiper open-up" data-aos="zoom-out">

                    <div class="swiper-wrapper d-flex">

                        @foreach ($products as $item)
                            <div class="swiper-slide">

                                <div class="product-item image-zoom-effect link-effect">

                                    <div class="image-holder position-relative">

                                        <a href="{{ route('shop#productDetails', $item->id) }}">

                                            <img src="{{ asset('productImage/' . $item->image) }}" alt="categories"
                                                class="product-image img-fluid rounded w-100 object-fit-cover"
                                                style="height: 400px; overflow: hidden;" />

                                        </a>
                                        @php
                                            $isInWishlist =
                                                Auth::check() && $wishlistItems->firstWhere('product_id', $item->id);
                                        @endphp
                                        <a href="#"
                                            title="{{ $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}"
                                            class="btn-icon btn-wishlist wishlist-toggle"
                                            data-product-id="{{ $item->id }}">

                                            <i class="{{ $isInWishlist ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>

                                        </a>


                                        <div class="product-content">

                                            <h5 class="element-title text-uppercase fs-5 mt-3">

                                                <a href="{{ route('shop#productDetails', $item->id) }}">
                                                    {{ $item->name }}
                                                </a>

                                            </h5>


                                            <a href="#" class="text-decoration-none add-to-cart-related"
                                                data-product-id="{{ $item->id }}" data-qty="1"
                                                data-after="Add to cart">

                                                <span>
                                                    {{ number_format($item->price) }} MMK
                                                </span>

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="icon-arrow icon-arrow-left d-inline-flex align-items-center justify-content-center p-2"
                    style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>


                <div class="icon-arrow icon-arrow-right d-inline-flex align-items-center justify-content-center p-2"
                    style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>

            </div>

        </section>
    @endsection
