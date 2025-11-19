@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
        </div>

        @if (session('create'))
            <div class="alert alert-success alert-dismissible fade show col-lg-6 col-md-8 col-12 mx-auto" role="alert">
                {{ session('create') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
                <div class="card p-3 shadow-sm rounded">
                    <form action="{{ route('product#create') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Image Upload -->
                            <div class="mb-3 text-center">
                                <img class="img-profile rounded mb-2 img-fluid" style="max-width: 200px;" id="output">
                                <input type="file" name="image" accept="image/*"
                                    class="form-control mt-1 @error('image') is-invalid @enderror"
                                    onchange="loadFile(event)">
                                @error('image')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Product Name & Category -->
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Product name">
                                        @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Category Name</label>
                                        <select name="categoryId"
                                            class="form-control @error('categoryId') is-invalid @enderror">
                                            <option value="">Choose Category...</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('categoryId') == $item->id) selected @endif>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categoryId')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Price & Stock -->
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Price</label>
                                        <input type="text" name="price" value="{{ old('price') }}"
                                            class="form-control @error('price') is-invalid @enderror" placeholder="Price">
                                        @error('price')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Stock</label>
                                        <input type="text" name="stock" value="{{ old('stock') }}"
                                            class="form-control @error('stock') is-invalid @enderror" placeholder="Stock">
                                        @error('stock')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" cols="30" rows="5"
                                    class="form-control @error('description') is-invalid @enderror" placeholder="Description">{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="mb-3">
                                <input type="submit" value="Create Product" class="btn btn-dark w-100 rounded shadow-sm">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
