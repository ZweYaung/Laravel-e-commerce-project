@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Product</h1>
        </div>

        @if (session('update'))
            <div class="alert alert-success alert-dismissible fade show col-12 col-md-4" role="alert">
                {{ session('update') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 card py-3 shadow-sm rounded">
                <form action="{{ route('product#update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="productImage" value="{{ $product->image }}">
                    <input type="hidden" name="productId" value="{{ $product->id }}">

                    <a href="{{ route('admin#product') }}"
                        class="btn bg-dark text-white mt-2 mx-2 rounded shadow-sm">Back</a>

                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <img id="output" src="{{ asset('productImage/' . $product->image) }}"
                                class="img-thumbnail rounded mb-2"
                                style="max-width: 100%; height: auto; max-height: 200px;">
                            <input type="file" accept="image/*" name="image"
                                class="form-control mt-1 @error('image') is-invalid @enderror" onchange="loadFile(event)">
                            @error('image')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                        class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                                    @error('name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <select name="categoryId"
                                        class="form-control @error('categoryId') is-invalid @enderror">
                                        <option value="">Choose Category</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}"
                                                @if (old('categoryId', $product->category_id) == $item->id) selected @endif>
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

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="text" name="price" value="{{ old('price', $product->price) }}"
                                        class="form-control @error('price') is-invalid @enderror" placeholder="Price">
                                    @error('price')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="text" name="stock" value="{{ old('stock', $product->stock) }}"
                                        class="form-control @error('stock') is-invalid @enderror" placeholder="Stock">
                                    @error('stock')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="submit" value="Update Product" class="btn btn-dark w-100 rounded shadow-sm">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
