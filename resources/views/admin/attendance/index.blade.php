@extends('layouts.master')

@section('title', 'UBN - Attendance')
@section('content')

    <div class="mt-4">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Take Attendance of Circle Members</h5>
                <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>
            <form action="{{ route('attendance.attendanceStore') }}" method="POST">
                @csrf

                <input type="hidden" name="circleId" value="{{ $circleId }}">
                <input type="hidden" name="meetingId" value="{{ $meetingId }}">

                <!-- Add margin around the table -->
                <div class="table-responsive m-3">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Name</th>
                                <th width="5%">Check the box</th>
                                {{-- <th width="5%"><input type="checkbox" id="checkAll"> Select All </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($circleMembers as $member)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $member->firstName }} {{ $member->lastName }}</td>
                                    <td>
                                        @php
                                            $attendance = App\Models\CircleMeetingsAttendances::where(
                                                'circleId',
                                                $circleId,
                                            )
                                                ->where('userId', $member->userId)
                                                ->first();
                                        @endphp
                                        <input type="checkbox" name="userId[]" value="{{ $member->userId }}"
                                            {{ $attendance ? 'checked' : '' }} {{ $attendance ? 'disabled' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Buttons with margin on top -->
                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </form>
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
                var isChecked = $(this).is(':checked');
                $('tbody input:checkbox').prop('checked', isChecked);
            });
        });
    </script>
@endsection
