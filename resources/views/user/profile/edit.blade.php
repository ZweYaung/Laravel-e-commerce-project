@extends('user.layouts.master')

@section('content')
    <div class="container-fluid my-5">
        <div class="position-relative col-12 col-md-10 mx-auto">

            <!-- Alerts -->
            @if (session('update'))
                <div class="d-flex justify-content-start mb-2">
                    <div class="alert alert-success alert-dismissible fade show w-auto" role="alert">
                        <small>{{ session('update') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            @if (session('remove'))
                <div class="d-flex justify-content-start mb-2">
                    <div class="alert alert-success alert-dismissible fade show w-auto" role="alert">
                        <small>{{ session('remove') }}</small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            <!-- Card -->
            <div class="card shadow mx-auto">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-gray-600">
                        Account Profile (<span
                            class="text-dark text-capitalize">{{ Auth::user()->name ?? Auth::user()->nickname }}</span>)
                    </h6>
                </div>

                <form action="{{ route('user#update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="oldImage" value="{{ Auth::user()->image }}">
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Image Column -->
                            <div class="col-12 col-lg-6 mb-4 mb-md-0 text-center">
                                <img class="img-profile rounded mb-3" id="output"
                                    src="{{ Auth::user()->image ? asset('profile_pic/' . Auth::user()->image) : asset('default/default_userImage.webp') }}"
                                    style="max-width: 250px; width: 80%; height: auto;">

                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <input type="file" accept="image/*" name="newImage" class="form-control w-auto"
                                        onchange="loadFile(event)">
                                    @if (Auth::user()->image)
                                        <a href="{{ route('user#removePhoto') }}"
                                            class="btn rounded btn-outline-danger">Remove Photo</a>
                                    @endif
                                </div>
                            </div>

                            <!-- User Info Column -->
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                        value="{{ old('name', Auth::user()->name ?? Auth::user()->nickname) }}">
                                    @error('name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', Auth::user()->email) }}" placeholder="Email">
                                    @error('email')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="number" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', Auth::user()->phone) }}" placeholder="09xxxxxx (Optional)">
                                    @error('phone')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <input type="submit" value="Update" class="btn btn-dark rounded mt-3">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
