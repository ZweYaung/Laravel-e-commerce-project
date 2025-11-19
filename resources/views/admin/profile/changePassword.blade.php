@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        @if (session('invalid-currentPassword'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('invalid-currentPassword') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form action="" method="post" class="p-3 rounded">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="currentPassword"
                                    class="form-control @error('currentPassword') is-invalid @enderror"
                                    placeholder="Current password">
                                @error('currentPassword')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="newPassword"
                                    class="form-control @error('newPassword') is-invalid @enderror"
                                    placeholder="New Password">
                                @error('newPassword')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="confirmPassword"
                                    class="form-control @error('confirmPassword') is-invalid @enderror"
                                    placeholder="Confirm password">
                                @error('confirmPassword')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div>
                                <input type="submit" value="Change" class="btn bg-dark text-white">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
