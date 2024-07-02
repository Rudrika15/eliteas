@extends('layouts.master')

@section('header', 'City')
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
        <h4 class="card-title">Scheduled Meetings</h4>
        <hr class="mb-5">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Meeting Date</th>
                    <th>Meeting Day</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($schedules && $schedules->count())
                @foreach ($schedules as $scheduleData)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($scheduleData->date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($scheduleData->date)->format('l') }}</td>
                    <td>
                        <a href="{{ route('attendance.takeAttendance', $scheduleData->id) }}"
                            class="btn btn-bg-orange btn-tooltip">
                            <i class="bi bi-person-check"></i>
                            <span class="btn-text">Take Internal Member Attendance</span>
                        </a>
                        <a href="{{ route('attendance.invitedAttendance', $scheduleData->id) }}"
                            class="btn btn-bg-blue btn-tooltip">
                            <i class="bi bi-person-fill-check"></i>
                            <span class="btn-text">Take External People's Attendance</span>
                        </a>
                        <a href="{{ route('attendance.attendanceList', $scheduleData->id) }}"
                            class="btn btn-bg-orange btn-tooltip">
                            <i class="bi bi-person-fill"></i>
                            <span class="btn-text">List of Attended Members</span>
                        </a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="3" class="text-center">No scheduled meetings found</td>
                </tr>
                @endif
            </tbody>
        </table>
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