@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between my-2">
            <div class="d-sm-flex align-items-center mb-2 mb-md-0">
                <h1 class="h3 mb-0 text-gray-800">User List</h1>
            </div>

            <div>
                <form action="" class="d-flex flex-column flex-sm-row" method="get">
                    <div class="input-group mb-2 mb-sm-0">
                        <input type="text" name="searchKey" value="" class="form-control" placeholder="Search">
                        <button type="submit" class="btn bg-dark text-white">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <a href="{{ route('account#userList') }}" class="btn ms-sm-2">
                        <i class="fa-solid fa-arrows-rotate align-middle"></i>
                    </a>
                </form>
            </div>
        </div>

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
                                <th>Provider</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($user) != 0)
                                @foreach ($user as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <img src="{{ $item->image != null ? asset('profile_pic/' . $item->image) : asset('default/default_userImage.webp') }}"
                                                class="img-fluid img-thumbnail rounded shadow-sm" style="max-width:100px;"
                                                alt="User Image">
                                        </td>
                                        <td>{{ $item->name ? $item->name : $item->nickname }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{!! $item->phone != null ? $item->phone : "<span class='text-muted'>No data</span>" !!}</td>
                                        <td>{{ $item->provider }}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <h5 class="text-muted text-center">There is no user</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    {{ $user->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
