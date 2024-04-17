@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">

                @role('Member')
                <div class="justify-content-center">
                    <div class="card-header"><b>Welcome! You are logged in..</b></div>
                </div>
                @endrole


                @role('Admin')
                <div class="card-header"><b>Upcoming Circle Meetings</b></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{-- <h2>{{ $count }}</h2> --}}
                    <a href="{{ route('schedule.dashIndex') }}">View Details</a>
                    @endrole

                </div>
            </div>
        </div>
    </div>
</div>
@endsection