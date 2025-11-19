@extends('user.layouts.master')

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">

        <div class="row d-flex justify-content-between align-items-center p-3">
            <div class="col-auto">
                <a href="{{ route('user#shop') }}" class="btn-link fs-5 text-dark">Back</a>
            </div>

            <div class="col-auto">
                @if (session('comment'))
                    <div style="height: 60px; width: 400px" class="alert alert-success alert-dismissible fade show me-5"
                        role="alert">
                        <small class="mb-5">{{ session('comment') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif
                @if (session('rate'))
                    <div style="height: 60px; width: 400px" class="alert alert-success alert-dismissible fade show me-5"
                        role="alert">
                        <small class="mb-5">{{ session('rate') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                @endif
                @if (session('addToCart'))
                    <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('addToCart') }}
                            </div>
                            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                                aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row px-xl-5 d-flex justify-content-around mb-3">
            <div class="col-lg-5 col-md-6 col-sm-12 pb-4  border-end">
                <div class="product-img position-relative object-fit-fill overflow-hidden p-0 text-center">
                    <img src="{{ asset('productImage/' . $product->image) }}" alt="Image" class="img-fluid rounded"
                        style="max-height: 500px;" />
                </div>
            </div>


            <div class="col-lg-6 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>

                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">

                        @for ($i = 1; $i <= $stars; $i++)
                            <i class="fas fa-star"></i>
                        @endfor

                        @for ($j = $stars + 1; $j <= 5; $j++)
                            <i class="far fa-star"></i>
                        @endfor

                        {{-- <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <i class="far fa-star"></i> --}}
                    </div>
                    <small class="pt-1">
                        ({{ count($comments) > 0 ? count($comments) : 0 }} Reviews)
                    </small>

                </div>
                <h3 class="font-weight-semi-bold mb-4">{{ number_format($product->price) }} MMK</h3>

                <form action="{{ route('user#addToCart') }}" method="post">
                    @csrf
                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="productId" value="{{ $product->id }}">
                    <div class="input-group quantity mb-5" style="width: 100px">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" name="qty" class="form-control form-control-sm text-center border-0"
                            value="1" />
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary rounded px-4 py-2 mb-4">
                        Add to cart
                    </button>
                </form>

                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="text-dark px-2" href=""><i class="fa-brands fa-x-twitter"></i></i></a>
                        <a class="text-dark px-2" href=""><i class="fab fa-linkedin-in"></i></a>
                        <a class="text-dark px-2" href=""><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-bs-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-bs-toggle="tab" href="#tab-pane-2">Reviews
                        ({{ count($comments) > 0 ? count($comments) : 0 }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>
                        <p>{{ $product->description }}</p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{ count($comments) > 0 ? count($comments) : 0 }} review for "Colorful
                                    Stylish Shirt"</h4>
                                @foreach ($comments as $item)
                                    <div class="media mb-4">
                                        <img src="{{ asset('profile_pic/' . $item->image) }}" alt="Image"
                                            class="img-fluid mr-3 mt-1 mb-2 rounded-circle" style="width: 35px" />
                                        <div class="media-body">
                                            <h6>
                                                {{ $item->name }}<small> -
                                                    <i>{{ $item->created }}</i></small>
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

                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <div class="border rounded p-3 bg-light">
                                    <label for="rating">Rating *</label>
                                    <form action="{{ route('user#rating') }}" method="post"
                                        class="d-flex col-lg-5 justify-content-between">
                                        @csrf
                                        <div class="rating-css">
                                            <div class="star-icon">
                                                <input type="hidden" name="productId" value="{{ $product->id }}">

                                                @if ($userRating == 0)
                                                    <input type="radio" value="1" name="productRating" checked
                                                        id="rating1">
                                                    <label for="rating1" class="fa fa-star"></label>

                                                    <input type="radio" value="2" name="productRating"
                                                        id="rating2">
                                                    <label for="rating2" class="fa fa-star"></label>

                                                    <input type="radio" value="3" name="productRating"
                                                        id="rating3">
                                                    <label for="rating3" class="fa fa-star"></label>

                                                    <input type="radio" value="4" name="productRating"
                                                        id="rating4">
                                                    <label for="rating4" class="fa fa-star"></label>

                                                    <input type="radio" value="5" name="productRating"
                                                        id="rating5">
                                                    <label for="rating5" class="fa fa-star"></label>
                                                @else
                                                    @for ($i = 1; $i <= $userRating; $i++)
                                                        <input type="radio" value="{{ $i }}"
                                                            name="productRating" checked id="rating{{ $i }}">
                                                        <label for="rating{{ $i }}"
                                                            class="fa fa-star"></label>
                                                    @endfor

                                                    @for ($j = $userRating + 1; $j <= 5; $j++)
                                                        <input type="radio" value="{{ $j }}"
                                                            name="productRating" id="rating{{ $j }}">
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

                                    <form action="{{ route('create#comment') }}" method="post">
                                        @csrf

                                        <input type="hidden" name="productId" value="{{ $product->id }}">

                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" name="message" cols="30" rows="5"
                                                class="form-control @error('message') is-invalid @enderror"></textarea>
                                            @error('message')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-2">
                                            <input type="submit" value="Submit" class="btn btn-primary px-3 rounded" />
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
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <section id="related-products" class="related-products product-carousel py-5 position-relative overflow-hidden">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 mb-3">
                <h4 class="text-uppercase">You May Also Like</h4>
                <a href="index.html" class="btn-link">View All Products</a>
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
    <!-- Products End -->
@endsection

@section('js-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.forEach(function(toastEl) {
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();
            });
        });
    </script>
@endsection
