@extends('layouts.master')

@section('content')

    <style>
        .badge-success {
            color: #0055ff;
            /* Change text color to white */
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .card-body {
            padding: 1.25rem;
        }

        .btn-back {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
        }

        .btn-back:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="card-title m-0">Show User</h2>
            <a class="btn btn-bg-orange" href="{{ route('users.index') }}">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>First Name:</strong>
                        {{ $user->firstName }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Last Name:</strong>
                        {{ $user->lastName }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $user->email }}
                    </div>
                </div>
                <div class="col-md-6">
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
                    <div class="col-lg-12 mt-3">
                        <div class="text-right">
                            <a class="btn btn-bg-orange" href="{{ route('members.show', $user->id) }}">Show Full Profile</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
