@extends('admin.layouts.master')

@section('content')
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between my-2">
            <div class="d-sm-flex align-items-center mb-2 mb-md-0">
                <h1 class="h3 mb-0 text-gray-800">Admin List</h1>
            </div>

            <div>
                <form action="" class="d-flex flex-column flex-sm-row" method="get">
                    <div class="input-group mb-2 mb-sm-0">
                        <input type="text" name="searchKey" value="" class="form-control" placeholder="Search">
                        <button type="submit" class="btn bg-dark text-white">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <a href="{{ route('account#adminList') }}" class="btn ms-sm-2">
                        <i class="fa-solid fa-arrows-rotate align-middle"></i>
                    </a>
                </form>
            </div>
        </div>

        @if (session('delete'))
            <div class="ml-2 alert alert-success alert-dismissible fade show col-12 col-md-6 col-lg-4" role="alert">
                {{ session('delete') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover shadow-sm">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($admin) != 0)
                                @foreach ($admin as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            @if ($item->image == null)
                                                <img src="{{ asset('default/default_profile.png') }}"
                                                    class="img-thumbnail rounded shadow-sm" style="width:100px"
                                                    alt="">
                                            @else
                                                <img src="{{ File::exists(public_path('profile_pic/' . $item->image)) ? asset('profile_pic/' . $item->image) : $item->image }}"
                                                    class="img-thumbnail rounded shadow-sm" style="width:100px"
                                                    alt="">
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{!! $item->phone != null ? $item->phone : "<span class='text-muted'>No data</span>" !!}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('edit#admin', [$item->id, $item->image != null ? $item->image : 0]) }}"
                                                class="btn btn-sm btn-outline-secondary">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('delete#Admin', [$item->id, $item->image != null ? $item->image : 0]) }}"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <h5 class="text-muted text-center">There is no admin</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <span>{{ $admin->links() }}</span>
            </div>
        </div>
    </div>

@endsection
