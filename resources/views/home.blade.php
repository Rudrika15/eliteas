@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><b>Your Next Circle Meetings</b></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>{{ $count }}</h2>
                    <a href="{{ route('schedule.dashIndex') }}">View Details</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection