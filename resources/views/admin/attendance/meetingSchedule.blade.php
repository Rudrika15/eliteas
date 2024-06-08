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
        <h4 class="mb-0 mt-3">Scheduled Meetings</h4>
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
                        <a href="{{ route('attendance.takeAttendance', $scheduleData->id) }}" class="btn btn-bg-orange">
                            <i class="bi bi-person-check"></i>
                        </a>
                        <a href="{{ route('attendance.list', $scheduleData->id) }}" class="btn btn-bg-blue">
                            <i class="bi bi-person-fill"></i>
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