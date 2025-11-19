@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 card p-3 shadow-sm rounded">

                <div class="d-flex justify-content-end">
                    <a href="{{ route('account#adminList') }}" class="btn bg-outline-dark my-2 w-25 rounded shadow-sm">
                        <i class="fa-solid fa-users"></i> Admin List
                    </a>
                </div>

                <div class="card-title text-dark p-3 h5 text-center rounded border-bottom">
                    Create New Admin
                </div>

                <form action="{{ route('create#Admin') }}" method="post">
                    @if (session('create'))
                        <div class="alert alert-success alert-dismissible fade show mx-auto col-10" role="alert">
                            {{ session('create') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                            @error('name')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                            @error('email')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="confirmPassword"
                                class="form-control @error('confirmPassword') is-invalid @enderror"
                                placeholder="Confirm Password">
                            @error('confirmPassword')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Create" class="btn btn-dark w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
