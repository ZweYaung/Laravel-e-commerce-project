@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-12">
                <div class="card">
                    <div class="card-body shadow">
                        <div class="mb-3">
                            <a href="{{ route('admin#payment') }}" class="btn bg-dark text-white mb-3 w-25 rounded shadow-sm">
                                Back
                            </a>
                        </div>

                        <form action="{{ route('payment#update', $payment->id) }}" method="post" class="p-3 rounded">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" name="accountNumber"
                                    value="{{ old('accountNumber', $payment->account_number) }}"
                                    class="form-control @error('accountNumber') is-invalid @enderror"
                                    placeholder="Account number">
                                @error('accountNumber')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Account Name</label>
                                <input type="text" name="accountName"
                                    value="{{ old('accountName', $payment->account_name) }}"
                                    class="form-control @error('accountName') is-invalid @enderror"
                                    placeholder="Account name">
                                @error('accountName')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Account Type</label>
                                <input type="text" name="accountType" value="{{ old('accountType', $payment->type) }}"
                                    class="form-control @error('accountType') is-invalid @enderror"
                                    placeholder="Account type">
                                @error('accountType')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <input type="submit" value="Update" class="btn btn-outline-dark w-100 mt-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
