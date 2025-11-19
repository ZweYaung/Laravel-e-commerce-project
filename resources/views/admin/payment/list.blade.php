@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Payment Methods</h1>
        </div>

        @if (session('create'))
            <div class="alert alert-success alert-dismissible fade show col-4" role="alert">
                {{ session('create') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('delete'))
            <div class="alert alert-success alert-dismissible fade show col-4" role="alert">
                {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('update'))
            <div class="alert alert-success alert-dismissible fade show col-4" role="alert">
                {{ session('update') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('payment#create') }}" method="post" class="p-3 rounded">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Account Number</label>
                                <input type="text" name="accountNumber" value="{{ old('accountNumber') }}"
                                    class="form-control @error('accountNumber') is-invalid @enderror"
                                    placeholder="Account number">
                                @error('accountNumber')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Account Name</label>
                                <input type="text" name="accountName" value="{{ old('accountName') }}"
                                    class="form-control @error('accountName') is-invalid @enderror"
                                    placeholder="Account name">
                                @error('accountName')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Account Type</label>
                                <input type="text" name="accountType" value="{{ old('accountType') }}"
                                    class="form-control @error('accountType') is-invalid @enderror"
                                    placeholder="Account type">
                                @error('accountType')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <input type="submit" value="Create" class="btn btn-outline-dark w-100">
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Account Number</th>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($payments) != 0)
                                @foreach ($payments as $item)
                                    <tr>
                                        <td>{{ $item->account_number }}</td>
                                        <td>{{ $item->account_name }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>
                                            <a href="{{ route('payment#edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('payment#delete', $item->id) }}"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        There is no payment method
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection
