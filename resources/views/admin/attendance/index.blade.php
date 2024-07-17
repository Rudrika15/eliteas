@extends('layouts.master')

@section('header', 'City')
@section('content')


<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Take Attendance of Circle Members</h5>
        <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>
    <form action="{{ route('attendance.attendanceStore') }}" method="POST">
        @csrf

        <input type="hidden" name="circleId" value="{{ $circleId }}">
        <input type="hidden" name="meetingId" value="{{ $meetingId }}">

        <table class="table datatable table-striped table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Name</th>
                    </tr>
                    </thead>
                    <th width="5%"><input type="checkbox" id="checkAll"> Check All </th>
            <tbody>
                @foreach ($circleMembers as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->firstName }} {{ $member->lastName }}</td>
                    <td>
                        @php
                            $attendance = App\Models\CircleMeetingsAttendances::where('circleId', $circleId)->where('userId', $member->userId)->first()
                        @endphp
                        <input type="checkbox" name="userId[]" value="{{ $member->userId }}" {{ $attendance ? 'checked' : '' }} {{ $attendance ? 'disabled' : '' }}>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
</div>
@endsection


{{--
<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Take Attendance of Invited Peoples</h5>
    </div>
    <form action="{{ route('attendance.attendanceStore') }}" method="POST">
        @csrf
        <table class="table datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Name</th>
                    <th width="5%"><input type="checkbox" id="checkAll"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meetingInvitations as $meetingInvitationsData)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $meetingInvitationsData->personName }}</td>
                    <td><input type="checkbox" name="personName[]" value="{{ $meetingInvitationsData->personName }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center mb-3">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form>
</div> --}}

@section('scripts')
<script>
    $(document).ready(function() {
        $('#checkAll').click(function() {
            $('input:checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>
@endsection