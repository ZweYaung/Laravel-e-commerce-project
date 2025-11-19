@extends('admin.layouts.master')

@section('content')
    <div class="container my-4 p-5">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-11 col-12">

                @if (session('update'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('update') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('remove'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('remove') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <!-- Card -->
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-gray-600">
                            Admin Profile ( <span class="text-dark text-capitalize">{{ Auth::user()->role }}</span> )
                        </h6>
                    </div>

                    <form action="{{ route('profile#update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <a href="{{ route('admin#profile') }}"
                            class="btn bg-dark text-white mt-2 mx-2 rounded shadow-sm">Back</a>
                        <input type="hidden" name="oldImage" value="{{ Auth::user()->image }}">

                        <div class="card-body">
                            <div class="row">
                                <!-- Profile Image -->
                                <div class="col-lg-6 col-12 text-center mb-4 mb-lg-0">
                                    <img class="img-profile rounded my-2 img-fluid" id="output"
                                        style="max-width: 250px; max-height: 250px; object-fit: cover;"
                                        src="{{ Auth::user()->image != null ? asset('profile_pic/' . Auth::user()->image) : asset('default/default_profile.png') }}">

                                    <div class="row mt-2 g-2 justify-content-center">
                                        <div class="col-12 col-md-7">
                                            <input type="file" accept="image/*" name="newImage" class="form-control"
                                                onchange="loadFile(event)">
                                        </div>
                                        @if (Auth::user()->image != null)
                                            <div class="col-12 col-md-4">
                                                <a href="{{ route('profile#removePhoto') }}"
                                                    class="btn btn-outline-danger w-100">Remove Photo</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Form Fields -->
                                <div class="col-lg-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', Auth::user()->name) }}" placeholder="Name">
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
                                            value="{{ old('phone', Auth::user()->phone) }}"
                                            placeholder="09xxxxxx (Optional)">
                                        @error('phone')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <input type="submit" value="Update" class="btn btn-dark mt-3">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
