@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="" method="post" class="p-2 rounded">
                            <a href="{{ route('admin#category') }}"
                                class="btn bg-dark text-white my-3 mx-2 rounded shadow-sm">Back</a>
                            @csrf
                            <input type="text" name="categoryName" value="{{ old('categoryName', $category->name) }}"
                                class="my-3 form-control @error('categoryName') is-invalid @enderror"
                                placeholder="Category Name...">
                            @error('categoryName')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror

                            <input type="submit" value="Update" class="btn btn-dark my-3">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
