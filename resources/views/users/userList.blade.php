@extends('layouts.master')

@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mt-3 card-title">Users Management</h2>
            {{-- <a class="btn btn-bg-orange mt-3 btn-sm btn-tooltip" href="{{ route('users.create') }}">
                <i class="bi bi-person-plus"></i>
                <span class="btn-text">Add User</span>
            </a> --}}
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table datatable table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        {{-- <th>Roles</th> --}}
                        {{-- <th width="280px">Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $user)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->firstName }}</td>
                        <td>{{ $user->lastName }}</td>
                        <td>{{ $user->email }}</td>
                        {{-- <td>
                            @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $v)
                            <label class="badge bg-success">{{ $v }}</label>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-bg-orange btn-sm btn-tooltip" href="{{ route('users.show', $user->id) }}">
                                <i class="bi bi-eye"></i>
                                <span class="btn-text">View User Details</span>
                            </a>
                            <a class="btn btn-bg-blue btn-sm btn-tooltip" href="{{ route('users.edit', $user->id) }}">
                                <i class="bi bi-pencil"></i>
                                <span class="btn-text">Edit User</span>
                            </a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' =>
                            'display:inline'])
                            !!}
                            <button type="submit" class="btn btn-danger btn-sm btn-tooltip">
                                <i class="bi bi-trash"></i>
                                <span class="btn-text">Delete User</span>
                            </button>
                            {!! Form::close() !!}
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end custom-pagination">
                {!! $data->links() !!}
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>
@endsection