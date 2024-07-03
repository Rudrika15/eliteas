@extends('layouts.master')

@section('header', 'Show Role')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mt-3 card-title">Show Role</h2>
                <a class="btn btn-bg-orange mt-3" href="{{ route('roles.index') }}">
                    Back
                </a>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mt-3">
                        <strong>Name:</strong>
                        <p>{{ $role->name }}</p>
                    </div>
                    <div class="form-group mt-3">
                        <strong>Permissions:</strong>
                        <div>
                            @if (!empty($rolePermissions))
                            @foreach ($rolePermissions as $v)
                            <span class="badge bg-success">{{ $v->name }}</span>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection