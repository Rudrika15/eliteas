@extends('layouts.master')

@section('content')
    {{-- Message --}}

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mt-3 card-title">Role Management</h2>
                @can('role-create')
                    <a class="btn btn-bg-orange btn-sm mt-3 btn-tooltip" href="{{ route('roles.create') }}">
                        <i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Role</span>
                    </a>
                @endcan
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <th>{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a class="btn btn-bg-orange btn-sm btn-tooltip"
                                        href="{{ route('roles.show', $role->id) }}">
                                        <i class="bi bi-eye"></i>
                                        <span class="btn-text">View Role Details</span>
                                    </a>
                                    @can('role-edit')
                                        <a class="btn btn-bg-blue btn-sm btn-tooltip"
                                            href="{{ route('roles.edit', $role->id) }}">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit Role</span>
                                        </a>
                                    @endcan
                                    @can('role-delete')
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                        <button type="submit" class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </button>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $roles->links() !!}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
@endsection
