@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Product List</h1>
        </div>

        @if (session('delete'))
            <div class="alert alert-success alert-dismissible fade show col-12 col-md-4" role="alert">
                {{ session('delete') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex flex-wrap justify-content-between my-2 gap-2">
            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-secondary rounded shadow-sm">
                    <i class="fa-solid fa-database"></i> Product Count ({{ count($product) }})
                </button>
                <a href="{{ route('admin#product') }}" class="btn btn-outline-primary rounded shadow-sm">All Products</a>
                <a href="{{ route('admin#product', 'lowStock') }}" class="btn btn-outline-danger rounded shadow-sm">
                    Low Stock Products
                </a>
            </div>
            <form action="{{ route('admin#product') }}" method="get" class="d-flex flex-grow-1 flex-sm-grow-0">
                <div class="input-group">
                    <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                        placeholder="Search">
                    <button type="submit" class="btn bg-dark text-white"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover shadow-sm">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($product) != 0)
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    <img src="{{ asset('productImage/' . $item->image) }}"
                                        class="img-thumbnail rounded shadow-sm"
                                        style="width:80px; height:auto; max-height:130px;" alt="">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ number_format($item->price) }} MMK</td>
                                <td>
                                    <button type="button" class="btn btn-secondary position-relative">
                                        {{ $item->stock }}
                                        @if ($item->stock <= 3)
                                            <span
                                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                Low stock!
                                            </span>
                                        @endif
                                    </button>
                                </td>
                                <td>{{ $item->category_name }}</td>
                                <td>
                                    <a href="{{ route('product#edit', $item->id) }}"
                                        class="btn btn-sm btn-outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="{{ route('product#delete', [$item->id, $item->image]) }}"
                                        class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center text-muted">There is no product</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $product->links() }}
        </div>
    </div>

@endsection
