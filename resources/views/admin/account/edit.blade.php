@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid py-3">

        @if (session('update'))
            <div class="alert alert-success alert-dismissible fade show mx-auto col-12 col-md-8 col-lg-6" role="alert">
                {{ session('update') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('remove'))
            <div class="alert alert-success alert-dismissible fade show mx-auto col-12 col-md-8 col-lg-6" role="alert">
                {{ session('remove') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card mx-auto shadow col-12 col-md-10 col-lg-8 p-0">
            <div class="card-header py-3 text-center text-md-left">
                <h6 class="m-0 font-weight-bold text-gray-600">
                    {{ $admin->name }}
                    (<span class="text-dark text-capitalize">{{ $admin->role }}</span>)
                </h6>
            </div>

            <form action="{{ route('update#admin', $admin->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 gap-2">
                    <a href="{{ route('account#adminList') }}" class="btn bg-dark text-white rounded shadow-sm w-md-auto">
                        Back
                    </a>
                </div>

                <input type="hidden" name="oldImage" value="{{ $admin->image }}">

                <div class="card-body">
                    <div class="row g-4">


                        <div class="col-12 col-md-5 text-center">
                            <img class="img-fluid img-profile rounded shadow-sm mb-3" id="output"
                                src="{{ $admin->image != 0 ? asset('profile_pic/' . $admin->image) : asset('default/default_profile.png') }}"
                                style="max-height: 300px; object-fit: cover;" alt="Profile Image">

                            <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center gap-2">
                                <input type="file" accept="image/*" name="newImage" class="form-control w-100"
                                    onchange="loadFile(event)">

                                @if ($admin->image != 0)
                                    <a href="{{ route('admin#removePhoto', [$admin->id, $admin->image]) }}"
                                        class="btn btn-outline-danger w-100 w-sm-auto d-flex align-items-center justify-content-center">
                                        <span class="d-none d-md-inline">Remove Photo</span>
                                        <i class="fa-solid fa-trash d-inline d-md-none"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                    value="{{ old('name', $admin->name) }}">
                                @error('name')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="text" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                    value="{{ old('email', $admin->email) }}">
                                @error('email')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="number" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="09xxxxxx (Optional)" value="{{ old('phone', $admin->phone) }}">
                                @error('phone')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <input type="submit" value="Update" class="btn btn-dark w-100 py-2">
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        function loadFile(event) {
            const output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            };
        }
    </script>
@endsection
