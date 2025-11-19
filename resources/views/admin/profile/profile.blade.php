@extends('admin.layouts.master')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="card shadow mb-4 w-100" style="max-width: 1000px;">
            <div class="card-header py-3 text-center">
                <h6 class="m-0 font-weight-bold text-gray-600">Account Information</h6>
            </div>

            <form>
                <div class="card-body">
                    <div class="row">
                        <!-- Profile Image -->
                        <div class="col-lg-4 col-md-5 col-12 text-center mb-3 mb-md-0">
                            <img class="img-profile mt-3 img-fluid rounded" id="output"
                                src="{{ Auth::user()->image != null ? asset('profile_pic/' . Auth::user()->image) : asset('default/default_profile.png') }}">
                        </div>

                        <!-- Info Section -->
                        <div class="col-lg-8 col-md-7 col-12">
                            <div class="row mt-3">
                                <div class="col-5 font-weight-bold h5">
                                    {{ Auth::user()->name != null ? 'Name :' : 'Nickname :' }}
                                </div>
                                <div class="col-7 h5">
                                    {{ Auth::user()->name != null ? Auth::user()->name : Auth::user()->nickname }}
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-5 font-weight-bold h5">Email :</div>
                                <div class="col-7 h5">{{ Auth::user()->email }}</div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-5 font-weight-bold h5">Phone :</div>
                                <div class="col-7 h5">
                                    {!! Auth::user()->phone != null ? Auth::user()->phone : "<span class='text-muted'>No data</span>" !!}
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-5 font-weight-bold h5">Role :</div>
                                <div class="col-7 h5 text-danger text-capitalize">{{ Auth::user()->role }}</div>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-3">
                                <a href="{{ route('admin#changePasswordPage') }}"
                                    class="btn bg-secondary text-white btn-sm rounded shadow-sm d-block d-sm-inline-block mb-2 mb-sm-0">
                                    <i class="fa-solid fa-lock"></i> Change Password
                                </a>
                                <a href="{{ route('profile#edit') }}"
                                    class="btn btn-dark text-white btn-sm rounded shadow-sm d-block d-sm-inline-block">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
