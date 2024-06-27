@extends('layouts.master')

@section('header', 'Meetings Leaderboard')
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
            <h4 class="card-title">Meetings Leaderboard</h4>
            <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm ">Back</a>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Name of Member</th>
                    <th>Circle Name</th>
                    <th>Meeting Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($circlecalls as $circlecall)
                <tr>
                    <td>{{ $circlecall['member']->firstName ?? '-' }} {{ $circlecall['member']->lastName ?? '-' }} <i
                            class="bi bi-trophy" style="color: gold;"></i></td>
                    <td>{{ $circlecall['member']->circle->circleName ?? '-' }}</td>
                    <td>{{ $circlecall['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</div>
@endsection
