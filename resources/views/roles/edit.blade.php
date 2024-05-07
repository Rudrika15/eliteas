@extends('layouts.master')

@section('header', 'Edit Role')
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
        <h5 class="card-title">Edit Role</h5>
        <a href="{{ route('roles.index') }}" class="btn btn-bg-orange btn-sm">Back</a>
    </div>
    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="rolesForm" enctype="multipart/form-data" method="post"
        action="{{ route('roles.update', $role->id) }}" novalidate>
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group mt-3">
                    <strong>Name:</strong>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name', $role->name) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <br />
                    @foreach ($permission as $value)
                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true :
                        false, ['class' => 'name']) }}
                        {{ $value->name }}</label>
                    <br />
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <a href="{{ route('roles.index') }}" class="btn btn-bg-orange">Cancel</a>
            </div>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection