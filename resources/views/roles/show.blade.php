@extends('layouts.master')

@section('header', 'Show Role')
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
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Show Role</h5>
        <a href="{{ route('roles.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group mt-3">
                <strong>Name:</strong>
                {{ $role->name }}
            </div>
            <div class="form-group">
                <strong>Permissions:</strong>
                @if (!empty($rolePermissions))
                @foreach ($rolePermissions as $v)
                <label class="label label-success">{{ $v->name }},</label>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
