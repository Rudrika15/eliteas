@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
        <h2>Users Management</h2>
        {{-- <a class="btn btn-success" href="{{ route('users.create') }}">
            <i class="bi bi-person-plus"></i>
        </a> --}}
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
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Roles</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->firstName }}</td>
        <td>{{ $user->lastName }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if (!empty($user->getRoleNames()))
            @foreach ($user->getRoleNames() as $v)
            <label class="badge bg-success">{{ $v }}</label>
            @endforeach
            @endif
        </td>
        <td>
            <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">
                <i class="bi bi-eye"></i>
            </a>
            <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">
                <i class="bi bi-pencil"></i>
            </a>
            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline'])
            !!}
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i>
            </button>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
</table>

{!! $data->render() !!}
@endsection