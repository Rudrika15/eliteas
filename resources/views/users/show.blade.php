@extends('layouts.master')

@section('content')

<style>
    .badge-success {
        color: #0055ff;
        /* Change text color to white */
    }
</style>


<div class="row">
    <div class="col-lg-12 margin-tb d-flex align-items-center justify-content-between">
        <h2 class="mr-auto"> Show User</h2>
        <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group mt-3">
            <strong>First Name:</strong>
            {{ $user->firstName }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Last Name:</strong>
            {{ $user->lastName }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            {{ $user->email }}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Roles:</strong>
            @if (!empty($user->getRoleNames()))
            @foreach ($user->getRoleNames() as $v)
            <label class="badge badge-success">{{ $v }}</label>
            @endforeach
            @endif
        </div>
    </div>
</div>

@if ($user->hasRole('Member'))
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('members.show', $user->id) }}"> Show Full Profile</a>
        </div>
    </div>
</div>
@endif
@endsection