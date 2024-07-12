@extends('layouts.master')

@section('header', 'Schedule')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Schedule</h4>
            <a href="{{ route('circle.index') }}" class="btn btn-bg-orange btn-sm mt-3">BACK</a>
        </div>

        {{-- Filter Dropdown --}}
        <div class="col-md-3 mb-3">
            <div class="d-flex align-items-center">
                <small class="text-muted me-3"><strong>Filter By:</strong></small>
                <select id="circleFilter" class="form-select mt-3 me-3">
                    <option value="">Select Circle</option>
                    @foreach ($circles as $circleData)
                    <option value="{{ $circleData->circleName }}">{{ $circleData->circleName }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="scheduleTable">
                <thead>
                    <tr>
                        <th>Circle Name</th>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Time</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedulesData)
                    <tr>
                        <td class="circle-name">{{ $schedulesData->circle->circleName }}</td>
                        <td>
                            @if($schedulesData->day == 0) Sunday @elseif($schedulesData->day == 1) Monday
                            @elseif($schedulesData->day == 2) Tuesday @elseif($schedulesData->day == 3) Wednesday
                            @elseif($schedulesData->day == 4) Thursday @elseif($schedulesData->day == 5) Friday
                            @elseif($schedulesData->day == 6) Saturday @else - @endif
                        </td>
                        <td>{{ $schedulesData->date }}</td>
                        <td>{{ $schedulesData->venue }}</td>
                        <td>{{ $schedulesData->meetingTime }}</td>
                        <td>{{ $schedulesData->remarks }}</td>
                        <td>
                            <a href="{{ route('schedule.edit', $schedulesData->id) }}"
                                class="btn btn-bg-blue btn-sm btn-tooltip">
                                <i class="bi bi-pen"></i>
                                <span class="btn-text">Edit</span>
                            </a>
                            {{-- <a href="{{ route('schedule.delete', $schedulesData->id) }}"
                                class="btn btn-danger btn-sm btn-tooltip">
                                <i class="bi bi-trash"></i>
                                <span class="btn-text">Delete</span>
                            </a> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $schedules->links() !!}
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#circleFilter').on('change', function() {
        var filterValue = this.value;
        fetchFilteredData(filterValue);
    });

    function fetchFilteredData(filterValue) {
        $.ajax({
            url: '{{ route('schedule.filter') }}',
            type: 'GET',
            data: { circle: filterValue },
            success: function(response) {
                console.log('Response:', response); // Debugging line
                var tableBody = $('#scheduleTable tbody');
                tableBody.empty();

                response.schedules.forEach(function(schedule) {
                    var row = `
                        <tr>
                            <td class="circle-name">${schedule.circle.circleName}</td>
                            <td>${getDayName(schedule.day)}</td>
                            <td>${schedule.date}</td>
                            <td>${schedule.venue}</td>
                            <td>${schedule.meetingTime}</td>
                            <td>${schedule.remarks}</td>
                            <td>
                                <a href="/schedule/edit/${schedule.id}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                    <i class="bi bi-pen"></i>
                                    <span class="btn-text">Edit</span>
                                </a>
                                <a href="/schedule/delete/${schedule.id}" class="btn btn-danger btn-sm btn-tooltip">
                                    <i class="bi bi-trash"></i>
                                    <span class="btn-text">Delete</span>
                                </a>
                            </td>
                        </tr>
                    `;
                    tableBody.append(row);
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error); // Debugging line
            }
        });
    }

    function getDayName(dayIndex) {
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return days[dayIndex] || '-';
    }
</script>

@endsection