@extends('layouts.master')

@section('title', 'Attendance')
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
        <h5 class="card-title">Take Attendance of Invited Peoples</h5>
        <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>
    <form action="{{ route('attendance.invitedAttendanceStore') }}" method="POST">
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
                @foreach ($meetingInvitations as $meetingInvitationsData)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $meetingInvitationsData->personName }}</td>
                    <td>
                        @php
                        $attendance = \App\Models\CircleMeetingsAttendances::where('circleId', $circleId)
                            ->where('name', $meetingInvitationsData->personName)
                            ->first();
                        @endphp
                        <input type="checkbox" name="personName[]" value="{{ $meetingInvitationsData->personName }}" {{ $attendance ? 'checked' : '' }} {{ $attendance ? 'disabled' : '' }}>
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
</div>
</div>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $('#checkAll').click(function() {
            $('input:checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>
@endsection