<!DOCTYPE html>
<html lang="en">

<head>
    <title>COS209 - STYLEHUB</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- bootstrap cdn link --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />

    <link rel="stylesheet" type="text/css" href="{{ asset('user/css/vendor.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('user/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('user/css/custom.css') }}" />

    {{-- font awesome cdn link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Marcellus&display=swap"
        rel="stylesheet" />
</head>

<body class="homepage">
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
        aria-labelledby="My Cart">
        <div class="offcanvas-header justify-content-center"> <button type="button" class="btn-close"
                data-bs-dismiss="offcanvas" aria-label="Close"></button> </div>

        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3"> <span class="text-primary">Your
                        Wishlist</span> <span class="badge bg-primary rounded-pill">{{ $wishlistItems->count() }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @forelse($wishlistItems as $item)
                        <form action="{{ route('user#addToCart') }}" method="post"> @csrf <li
                                class="list-group-item d-flex justify-content-between lh-sm">
                                <div class="d-flex justify-center"> <!-- Remove Button --> <a
                                        href="{{ route('wishlist#remove', $item->id) }}"
                                        class="d-flex align-items-center"> <i
                                            class="fa-solid fa-xmark text-primary"></i> </a>
                                    <div class="ms-2"> <a
                                            href="{{ route('shop#productDetails', $item->product->id) }}"
                                            title="See the product's details">
                                            <h6 class="my-0">{{ $item->product->name }}</h6>
                                        </a> <small
                                            class="text-body-secondary">{{ number_format($item->product->price) }}
                                            MMK</small> </div>
                                </div> <!-- Add to Cart Button --> <input type="hidden" name="userId"
                                    value="{{ Auth::user()->id }}"> <input type="hidden" name="productId"
                                    value="{{ $item->product->id }}"> <input type="hidden" name="qty"
                                    value="1"> <button type="submit" title="Add to Cart"
                                    class="border-0 bg-transparent"> <i class="fa-solid fa-cart-plus text-primary"></i>
                                </button>
                            </li>
                    </form> @empty <li class="list-group-item text-center text-muted"> No items in wishlist
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
    <nav class="navbar navbar-expand-lg bg-light text-uppercase fs-6 p-3 border-bottom align-items-center">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center w-100">
                <div class="col-auto">
                    <h1 class="fs-4 text-center mt-4"> STYLEHUB </h1>
                </div>
                <div class="col-auto"> <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"> <span
                            class="navbar-toggler-icon"></span> </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5> <button type="button"
                                class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 gap-1 gap-md-5 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user#home') ? 'active fw-semi-bold' : '' }}"
                                        href="{{ route('user#home') }}">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user#shop') ? 'active fw-semi-bold' : '' }}"
                                        href="{{ route('user#shop') }}">Shop</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user#about') ? 'active fw-semi-bold' : '' }}"
                                        href="{{ route('user#about') }}">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user#contact') ? 'active fw-semi-bold' : '' }}"
                                        href="{{ route('user#contact') }}">Contact</a>
                                </li>

                                <!-- Small screen Cart, Wishlist, Profile -->
                                <li class="nav-item d-lg-none mt-2">
                                    <a class="nav-link" href="{{ route('user#cart') }}">Cart <span
                                            class="cart-count">(
                                            {{ $cartCount }} )</span></a>
                                </li>
                                <li class="nav-item d-lg-none">
                                    <a class="nav-link" href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">Wishlist <span
                                            class="wish-count">( {{ $wishlistItems->count() }} )</span></a>
                                </li>
                                <li class="nav-item dropdown d-lg-none">
                                    <a class="dropdown-toggle nav-link" href="#" id="dropdownHomeMobile"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ Auth::user()->image ? asset('profile_pic/' . Auth::user()->image) : asset('default/default_userImage.webp') }}"
                                            class="img-profile rounded-circle me-1" style="height: 28px; width: 28px"
                                            alt="">
                                        <small>{{ Auth::user()->name ?? Auth::user()->nickname }}</small>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownHomeMobile">
                                        <li><a class="dropdown-item" href="{{ route('user#editPage') }}">Profile</a>
                                        </li>
                                        @if (Auth::user()->password)
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user#changePasswordPage') }}">Change Password</a>
                                            </li>
                                        @endif
                                        <li><a class="dropdown-item" href="{{ route('user#orderList') }}">Order
                                                List</a></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="post">
                                                @csrf
                                                <input type="submit" class="dropdown-item" value="LOGOUT">
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-auto col-lg-auto">
                    <ul class="list-unstyled d-flex m-0">
                        <li class="d-none d-lg-block"> <a href="{{ route('user#cart') }}"
                                class="text-uppercase mx-3">Cart <span class="cart-count">( {{ $cartCount }}
                                    )</span> </a> </li>
                        <li class="d-none d-lg-block"> <a href="index.html" class="text-uppercase mx-3"
                                data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart"
                                aria-controls="offcanvasCart">Wishlist <span class="wish-count">(
                                    {{ $wishlistItems->count() }} )</span> </a> </li>
                        <li class=" d-none d-lg-block dropdown"> <a class="dropdown-toggle" href="#"
                                id="dropdownHome" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"> <img
                                    src="{{ Auth::user()->image != null ? asset('profile_pic/' . Auth::user()->image) : asset('default/default_userImage.webp') }}"
                                    class="img-profile rounded-circle" style="height: 28px; width: 28px"
                                    alt="">
                                <small>{{ Auth::user()->name ? Auth::user()->name : Auth::user()->nickname }}</small>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownHome">
                                <li> <a href="{{ route('user#editPage') }}"
                                        class="dropdown-item item-anchor">Profile</a> </li>
                                @if (Auth::user()->password)
                                    <li> <a href="{{ route('user#changePasswordPage') }}"
                                            class="dropdown-item item-anchor">Change Password</a> </li>
                                @endif
                                <li> <a href="{{ route('user#orderList') }}" class="dropdown-item item-anchor">Order
                                        List</a> </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post"> @csrf <input type="submit"
                                            class="dropdown-item item-anchor" value="LOGOUT"> </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav> @yield('content') <footer id="footer" class="mt-5">
        <div class="container">
            <div class="row d-flex flex-wrap justify-content-between py-5">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-001">
                        <div class="footer-intro mb-4">
                            <h1 class="fs-4 text-center mt-4"> STYLEHUB </h1>
                        </div>
                        <p> Every piece we design is made with love, attention to detail, and a commitment to quality.
                            We take pride in blending timeless style with modern trends, making fashion accessible and
                            empowering for all. </p>
                        <div class="social-links">
                            <ul class="list-unstyled d-flex flex-wrap gap-3">
                                <li> <a href="#" class="text-secondary"> <svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#facebook"></use>
                                        </svg> </a> </li>
                                <li> <a href="#" class="text-secondary"> <svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#twitter"></use>
                                        </svg> </a> </li>
                                <li> <a href="#" class="text-secondary"> <svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#youtube"></use>
                                        </svg> </a> </li>
                                <li> <a href="#" class="text-secondary"> <svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#pinterest"></use>
                                        </svg> </a> </li>
                                <li> <a href="#" class="text-secondary"> <svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#instagram"></use>
                                        </svg> </a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-002">
                        <h5 class="widget-title text-uppercase mb-4">Quick Links</h5>
                        <ul class="menu-list list-unstyled text-uppercase border-animation-left fs-6">
                            <li class="menu-item"> <a href="{{ route('user#home') }}" class="item-anchor">Home</a>
                            </li>
                            <li class="menu-item"> <a href="{{ route('user#about') }}" class="item-anchor">About</a>
                            </li>
                            <li class="menu-item"> <a href="{{ route('user#shop') }}" class="item-anchor">Shop</a>
                            </li>
                            <li class="menu-item"> <a href="{{ route('user#contact') }}"
                                    class="item-anchor">Contact</a> </li>
                            <li class="menu-item"> <a href="{{ route('user#cart') }}" class="item-anchor">Cart</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-003">
                        <h5 class="widget-title text-uppercase mb-4">Help & Info</h5>
                        <ul class="menu-list list-unstyled text-uppercase border-animation-left fs-6">
                            <li class="menu-item"> <a href="#" class="item-anchor">Track Your Order</a> </li>
                            <li class="menu-item"> <a href="#" class="item-anchor">Returns + Exchanges</a>
                            </li>
                            <li class="menu-item"> <a href="#" class="item-anchor">Shipping + Delivery</a>
                            </li>
                            <li class="menu-item"> <a href="#" class="item-anchor">Contact Us</a> </li>
                            <li class="menu-item"> <a href="#" class="item-anchor">Find us easy</a> </li>
                            <li class="menu-item"> <a href="index.html" class="item-anchor">Faqs</a> </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-004 border-animation-left">
                        <h5 class="widget-title text-uppercase mb-4">Contact Us</h5>
                        <p> Do you have any questions or suggestions? <a href="#"
                                class="item-anchor">cos209@gmail.com</a> </p>
                        <p> Do you need support? Give us a call. <a href="tel:+43 720 11 52 78"
                                class="item-anchor">+95 78123459</a> </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-top py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d-flex flex-wrap">
                        <div class="shipping">
                            <span>We ship with:</span>
                            <img src="images/arct-icon.png" alt="icon" />
                            <img src="images/dhl-logo.png" alt="icon" />
                        </div>
                        <div class="payment-option">
                            <span>Payment Option:</span>
                            <img src="images/visa-card.png" alt="card" />
                            <img src="images/paypal-card.png" alt="card" />
                            <img src="images/master-card.png" alt="card" />
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <p>I do not own the design of this website.</p>
                        <p>
                            © Copyright 2022 Kaira. All rights reserved. Design by
                            <a href="https://templatesjungle.com" target="_blank">TemplatesJungle</a>
                            Distribution By
                            <a href="https://themewagon.com" target="blank">ThemeWagon</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('user/js/plugins.js') }}"></script>
    <script src="{{ asset('user/js/SmoothScroll.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="{{ asset('user/js/script.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script> @yield('js-script')
    <script>
        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output') output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0])
        }
    </script>
</body>

</html>
