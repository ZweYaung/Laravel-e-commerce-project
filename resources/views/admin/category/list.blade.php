@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category List</h1>
        </div>

        @if (session('delete'))
            <div class="alert alert-success alert-dismissible fade show col-12 col-md-6 col-lg-4" role="alert">
                {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('create'))
            <div class="alert alert-success alert-dismissible fade show col-12 col-md-6 col-lg-4" role="alert">
                {{ session('create') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('update'))
            <div class="alert alert-success alert-dismissible fade show col-12 col-md-6 col-lg-4" role="alert">
                {{ session('update') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <!-- Category Form -->
            <div class="col-12 col-md-6 col-lg-5 mb-4">
                <div class="card">
                    <div class="card-body shadow">
                        <form action="{{ route('create#category') }}" method="post" class="p-3 rounded">
                            @csrf
                            <input type="text" name="categoryName" value="{{ old('categoryName') }}"
                                class="form-control @error('categoryName') is-invalid @enderror"
                                placeholder="Category name">
                            @error('categoryName')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                            <input type="submit" value="Create" class="btn btn-outline-dark mt-3">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Category Table -->
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm">
                        <thead style="background-color: #8C907E" class="text-white">
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category as $item)
                                <tr class="p-3">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('update#categoryPage', $item->id) }}"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="{{ route('delete#category', $item->id) }}"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <span class="d-flex justify-content-center">{{ $category->links() }}</span>
            </div>
        </div>

    </div>
@endsection
