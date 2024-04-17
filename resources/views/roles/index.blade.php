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
            <h2 class="mt-3">Role Management</h2>
            @can('role-create')
            <a class="btn btn-success btn-sm mt-3" href="{{ route('roles.create') }}">
                <i class="bi bi-plus-circle"></i>
            </a>
            @endcan
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
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
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}">
                            <i class="bi bi-eye"></i>
                        </a>
                        @can('role-edit')
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}">
                            <i class="bi bi-pen"></i>
                        </a>
                        @endcan
                        @can('role-delete')
                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' =>
                        'display:inline'])
                        !!}
                        <button type="submit" class="btn btn-danger btn-sm1">
                            <i class="bi bi-trash"></i>
                        </button>
                        {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection