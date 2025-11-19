@extends('authentication.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-10">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">LOGIN</h1>
                                    </div>

                                    <form class="user" method="POST" action="{{ url('login') }}">
                                        @csrf
                                        <div class="form-group my-4">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                id="email" placeholder="Email" name="email"
                                                value="{{ old('email') }}" />
                                            @error('email')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group my-4">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror" id="password"
                                                placeholder="Password" name="password" />
                                            @error('password')
                                                <small class="invalid-feedback">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100 rounded">
                                            LOGIN
                                        </button>

                                        <hr />

                                        <div class="row">
                                            <div class="col-12 col-md-6 mb-2">
                                                <a href="{{ route('social#login', 'google') }}"
                                                    class="btn btn-outline-dark rounded w-100">
                                                    <i class="fab fa-google fa-fw me-2"></i>Login with Google
                                                </a>
                                            </div>
                                            <div class="col-12 col-md-6 mb-2">
                                                <a href="{{ route('social#login', 'github') }}"
                                                    class="btn btn-secondary rounded w-100">
                                                    <i class="fab fa-github fa-fw me-2"></i>Login with Github
                                                </a>
                                            </div>
                                        </div>
                                    </form>

                                    <hr />
                                    <div class="text-center">
                                        <a class="small btn-link" href="{{ route('register') }}">
                                            Don't have an account? Register
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
