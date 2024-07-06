@extends('layouts.master')

@section('header', 'City')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Circle Meeting Attendance</h4>
            <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm ">Back</a>
        </div>
        <hr class="mb-5">
        <div class="table-responsive">
            <table class="table datatable table-striped table-hover">
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
                            {{-- <div class="btn-group" role="group"> --}}
                                <a href="{{ route('attendance.takeAttendance', $scheduleData->id) }}"
                                    class="btn btn-bg-orange btn-tooltip">
                                    <i class="bi bi-person-check"></i>
                                    <span class="btn-text">Internal Attendance</span>
                                </a>
                                <a href="{{ route('attendance.invitedAttendance', $scheduleData->id) }}"
                                    class="btn btn-bg-blue btn-tooltip">
                                    <i class="bi bi-person-fill-check"></i>
                                    <span class="btn-text">External Attendance</span>
                                </a>
                                <a href="{{ route('attendance.attendanceList', $scheduleData->id) }}"
                                    class="btn btn-bg-orange btn-tooltip">
                                    <i class="bi bi-person-fill"></i>
                                    <span class="btn-text">Attendance List</span>
                                </a>
                            {{-- </div> --}}
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
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            responsive: true
        });
    });
</script>
@endsection