<!DOCTYPE html>
<html lang="en">

<head>
    <title>COS209 - STYLEHUB</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Auth status --}}
    @auth
        <meta name="user-id" content="{{ auth()->id() }}">
        <meta name="user-authenticated" content="true">
    @else
        <meta name="user-authenticated" content="false">
    @endauth

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous" />

    <link rel="stylesheet" type="text/css" href="{{ asset('user/css/vendor.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('user/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('user/css/custom.css') }}" />

    {{-- Font Awesome --}}
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

    {{-- Offcanvas Wishlist --}}
    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart"
        aria-labelledby="My Cart">
        <div class="offcanvas-header justify-content-center">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your Wishlist</span>
                    <span class="badge bg-primary rounded-pill wish-count-badge">
                        @auth {{ $wishlistItems->count() ?? 0 }}
                        @else
                        0 @endauth
                    </span>
                </h4>

                <ul class="list-group mb-3 wishlist-items" id="wishlistOffcanvasList">
                    @include('partials.wishlist-offcanvas-items')
                </ul>
            </div>
        </div>
    </div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg bg-light text-uppercase fs-6 p-3 border-bottom">
        <div class="container-fluid d-flex align-items-center justify-content-between">

            <!-- 1. Brand Logo (Left) -->
            <div class="col-auto">
                <h1 class="fs-4 text-center mt-4">STYLEHUB</h1>
            </div>

            <!-- Mobile Toggler Button -->
            <button class="navbar-toggler ms-auto me-2 d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- 2. Navigation Links / Offcanvas (Center) -->
            <div class="offcanvas offcanvas-end flex-grow-1" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body justify-content-center">
                    <ul class="navbar-nav gap-1 gap-md-4">
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
                        <li class="nav-item d-lg-none mt-2">
                            <a class="nav-link" href="{{ route('user#cart') }}">Cart <span class="cart-count">(
                                    {{ $cartCount ?? 0 }} )</span></a>
                        </li>
                        <li class="nav-item d-lg-none">
                            <a class="nav-link" href="#" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasCart">Wishlist <span class="wish-count">( @auth
                                        {{ $wishlistItems->count() ?? 0 }}
                                    @else
                                    0 @endauth )</span></a>
                        </li>
                        @auth
                            <li class="nav-item dropdown d-lg-none">
                                <a class="dropdown-toggle nav-link" href="#" id="dropdownHomeMobile"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Auth::user()->image ? asset('storage/profile_pic/' . Auth::user()->image) : asset('default/default_userImage.webp') }}"
                                        class="img-profile rounded-circle me-1" style="height: 28px; width: 28px"
                                        alt="Profile Picture">
                                    <small>{{ Auth::user()->name ?? Auth::user()->nickname }}</small>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownHomeMobile">
                                    <li><a class="dropdown-item" href="{{ route('user#editPage') }}">Profile</a></li>
                                    @if (Auth::user()->password)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user#changePasswordPage') }}">
                                                Change Password
                                            </a>
                                        </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user#orderList') }}">
                                            Order List
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <input type="submit" class="dropdown-item" value="LOGOUT">
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item d-lg-none mt-2">
                                <a class="nav-link" href="{{ route('login') }}?redirect={{ url()->current() }}">
                                    Login
                                </a>
                            </li>
                            <li class="nav-item d-lg-none">
                                <a class="nav-link" href="{{ route('register') }}">
                                    Register
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>

            <!-- 3. Right Actions (Cart, Wishlist, Profile - Desktop Only) -->
            <div class="d-none d-lg-flex align-items-center ms-auto">
                <ul class="list-unstyled d-flex m-0 align-items-center">
                    <li>
                        <a href="{{ route('user#cart') }}"
                            class="text-uppercase mx-3 text-dark text-decoration-none">Cart <span class="cart-count">(
                                <span id="cartCount">{{ $cartCount ?? 0 }}</span>
                                )</span></a>
                    </li>
                    <li>
                        <a href="#" class="text-uppercase mx-3 text-dark text-decoration-none"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">Wishlist <span
                                class="wish-count">( <span id="wishlistCount">@auth
                                        {{ $wishlistItems->count() ?? 0 }}
                                    @else
                                    0 @endauth
                                </span> )</span></a>
                    </li>
                    @auth
                        <li class="dropdown">
                            <a class="dropdown-toggle text-dark text-decoration-none ms-2" href="#"
                                id="dropdownHome" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->image ? asset('storage/profile_pic/' . Auth::user()->image) : asset('default/default_userImage.webp') }}"
                                    class="img-profile rounded-circle me-1" style="height: 28px; width: 28px"
                                    alt="Profile Picture">
                                <small>{{ Auth::user()->name ? Auth::user()->name : Auth::user()->nickname }}</small>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownHome">
                                <li><a href="{{ route('user#editPage') }}" class="dropdown-item item-anchor">Profile</a>
                                </li>
                                @if (Auth::user()->password)
                                    <li><a href="{{ route('user#changePasswordPage') }}"
                                            class="dropdown-item item-anchor">Change Password</a></li>
                                @endif
                                <li><a href="{{ route('user#orderList') }}" class="dropdown-item item-anchor">Order
                                        List</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <input type="submit" class="dropdown-item item-anchor" value="LOGOUT">
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}"
                                class="text-uppercase mx-2 text-dark text-decoration-none">Login</a>
                            <a href="{{ route('register') }}"
                                class="text-uppercase mx-2 text-dark text-decoration-none">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>

        </div>
    </nav>

    @yield('content')

    {{-- Footer --}}
    <footer id="footer" class="mt-5">
        <div class="container">
            <div class="row d-flex flex-wrap justify-content-between py-5">
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-001">
                        <div class="footer-intro mb-4">
                            <h1 class="fs-4 text-center mt-4">STYLEHUB</h1>
                        </div>
                        <p>Every piece we design is made with love, attention to detail, and a commitment to quality. We
                            take pride in blending timeless style with modern trends, making fashion accessible and
                            empowering for all.</p>
                        <div class="social-links">
                            <ul class="list-unstyled d-flex flex-wrap gap-3">
                                <li><a href="#" class="text-secondary"><svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#facebook"></use>
                                        </svg></a></li>
                                <li><a href="#" class="text-secondary"><svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#twitter"></use>
                                        </svg></a></li>
                                <li><a href="#" class="text-secondary"><svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#youtube"></use>
                                        </svg></a></li>
                                <li><a href="#" class="text-secondary"><svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#pinterest"></use>
                                        </svg></a></li>
                                <li><a href="#" class="text-secondary"><svg width="24" height="24"
                                            viewBox="0 0 24 24">
                                            <use xlink:href="#instagram"></use>
                                        </svg></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-002">
                        <h5 class="widget-title text-uppercase mb-4">Quick Links</h5>
                        <ul class="menu-list list-unstyled text-uppercase border-animation-left fs-6">
                            <li class="menu-item"><a href="{{ route('user#home') }}" class="item-anchor">Home</a>
                            </li>
                            <li class="menu-item"><a href="{{ route('user#about') }}" class="item-anchor">About</a>
                            </li>
                            <li class="menu-item"><a href="{{ route('user#shop') }}" class="item-anchor">Shop</a>
                            </li>
                            <li class="menu-item"><a href="{{ route('user#contact') }}"
                                    class="item-anchor">Contact</a></li>
                            <li class="menu-item"><a href="{{ route('user#cart') }}" class="item-anchor">Cart</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-003">
                        <h5 class="widget-title text-uppercase mb-4">Help & Info</h5>
                        <ul class="menu-list list-unstyled text-uppercase border-animation-left fs-6">
                            <li class="menu-item"><a href="#" class="item-anchor">Track Your Order</a></li>
                            <li class="menu-item"><a href="#" class="item-anchor">Returns + Exchanges</a></li>
                            <li class="menu-item"><a href="#" class="item-anchor">Shipping + Delivery</a></li>
                            <li class="menu-item"><a href="#" class="item-anchor">Contact Us</a></li>
                            <li class="menu-item"><a href="#" class="item-anchor">Find us easy</a></li>
                            <li class="menu-item"><a href="index.html" class="item-anchor">Faqs</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="footer-menu footer-menu-004 border-animation-left">
                        <h5 class="widget-title text-uppercase mb-4">Contact Us</h5>
                        <p>Do you have any questions or suggestions? <a href="#"
                                class="item-anchor">cos209@gmail.com</a></p>
                        <p>Do you need support? Give us a call. <a href="tel:+43 720 11 52 78" class="item-anchor">+95
                                78123459</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-top py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="mb-0">&copy; {{ date('Y') }} STYLEHUB. All rights reserved.</p>
                        <p class="mb-0 small text-muted">Built with <i class="fa-solid fa-heart text-dark"></i> for
                            fashion lovers everywhere.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- Toast & Modal --}}
    <div id="toastContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>
    <div class="modal fade" id="loginRequiredModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login Required</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="loginModalMessage">Please log in to perform this action.</p>
                    <div class="mt-3">
                        <div class="d-grid gap-2">
                            <a href="{{ route('login') }}?redirect={{ url()->current() }}"
                                class="btn btn-primary">Log In</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary">Create Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
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
    <script src="{{ asset('user/js/main.js') }}"></script>
    <script src="{{ asset('user/js/app.js') }}"></script>

    @yield('js-script')
</body>

</html>
