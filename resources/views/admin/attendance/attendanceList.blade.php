@extends('layouts.master')

@section('title', 'UBN - Attendance')
@section('content')

<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Attendance List</h5>
        <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th style="width:10px;" class="text-center">No</th>
                <th>Attended Person Name</th>
                {{-- <th>Invited Person</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($attendanceList as $index => $attendanceListData)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
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