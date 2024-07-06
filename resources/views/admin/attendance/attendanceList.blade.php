@extends('layouts.master')

@section('header', 'List')
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
        <h5 class="card-title">Attendance List</h5>
        <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>
    <table class="table datatable table-striped table-hover">
        <thead>
            <tr>
                <th>Attended Person Name</th>
                {{-- <th>Invited Person</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($attendanceList as $attendanceListData)
            <tr>
                <td>
                    {{ $attendanceListData->user ? $attendanceListData->user->firstName . ' ' .
                    $attendanceListData->user->lastName : $attendanceListData->name }}
                </td>
                {{-- <td> {{ $attendanceListData->name ?? null }} </td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>


@endsection