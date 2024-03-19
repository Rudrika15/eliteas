@extends('layouts.master')


@section('content')


<div class="row">
    <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
        <h2>Role Management</h2>
        @can('role-create')
        <a class="btn btn-success" href="{{ route('roles.create') }}">
            <i class="bi bi-plus-circle"></i>
        </a>
        @endcan
    </div>
</div>
</div>
</div>


@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif


<table class="table table-bordered mt-3">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info" href="{{ route('roles.show', $role->id) }}">
                <i class="bi bi-eye"></i>
            </a>
            @can('role-edit')
            <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">
                <i class="bi bi-pen"></i>
            </a>
            @endcan
            @can('role-delete')
            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline'])
            !!}
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i>
            </button>
            {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>


{!! $roles->render() !!}
@endsection