@extends('user.layouts.master')

@section('content')
    <div class="container-fluid my-5 mx-auto">

        <!-- Page Heading -->
        <div class="">
            <div class="row">
                <div class="col-6 offset-3">
                    <div class="card">
                        <div class="card-body shadow">
                            @if (session('invalid-currentPassword'))
                                <div style="height: 60px; width: 300px"
                                    class="alert alert-danger alert-dismissible fade show col-5" role="alert">
                                    <small class="mb-5">{{ session('invalid-currentPassword') }}</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            @endif
                            <form action="{{ route('user#changePassword') }}" method="post" class="p-3 rounded">
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
                                        class="form-control  @error('newPassword') is-invalid @enderror"
                                        placeholder="New Password">
                                    @error('newPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="confirmPassword"
                                        class="form-control  @error('confirmPassword') is-invalid @enderror"
                                        placeholder="Confirm password">
                                    @error('confirmPassword')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="">
                                    <input type="submit" value="Change" class="btn bg-dark rounded text-white">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
