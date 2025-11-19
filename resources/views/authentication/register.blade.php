@extends('authentication.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">REGISTER</h1>
                            </div>

                            <!-- Centered form -->
                            <form class="user col-12 col-md-8 offset-md-2" method="POST" action="{{ url('register') }}">
                                @csrf
                                <div class="form-group my-3">
                                    <input type="text"
                                        class="form-control form-control-user @error('name') is-invalid @enderror"
                                        id="exampleFirstName" placeholder="Username" name="name"
                                        value="{{ old('name') }}" />
                                    @error('name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group my-3">
                                    <input type="email"
                                        class="form-control form-control-user @error('email') is-invalid @enderror"
                                        id="exampleInputEmail" placeholder="Email" name="email"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group my-3">
                                    <input type="password"
                                        class="form-control form-control-user @error('password') is-invalid @enderror"
                                        id="exampleInputPassword" placeholder="Password" name="password" />
                                    @error('password')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group my-3">
                                    <input type="password"
                                        class="form-control form-control-user @error('password_confirmation') is-invalid @enderror"
                                        id="exampleRepeatPassword" placeholder="Confirm password"
                                        name="password_confirmation" />
                                    @error('password_confirmation')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group my-4">
                                    <button type="submit" class="w-100 rounded btn btn-primary btn-user btn-block">
                                        REGISTER
                                    </button>
                                </div>
                            </form>

                            <hr />

                            <div class="text-center">
                                <a class="small btn-link" href="{{ route('login') }}">
                                    Already have an account? Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
