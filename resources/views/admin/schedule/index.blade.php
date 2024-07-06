@extends('layouts.master')

@section('header', 'Schedule')
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
            <table class="table datatable table-striped table-hover" id="scheduleTable">
                <thead>
                    <tr>
                        <th>Circle Name</th>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Time</th>
                        <th>Remarks</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedulesData)
                    <tr>
                        <td class="circle-name">{{ $schedulesData->circle->circleName }}</td>
                        <td>
                            {{-- Display name based on meeting day --}}
                            @if($schedulesData->day == 0)
                            Sunday
                            @elseif($schedulesData->day == 1)
                            Monday
                            @elseif($schedulesData->day == 2)
                            Tuesday
                            @elseif($schedulesData->day == 3)
                            Wednesday
                            @elseif($schedulesData->day == 4)
                            Thursday
                            @elseif($schedulesData->day == 5)
                            Friday
                            @elseif($schedulesData->day == 6)
                            Saturday
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ $schedulesData->date }}</td>
                        <td>{{ $schedulesData->venue }}</td>
                        <td>{{ $schedulesData->meetingTime }}</td>
                        <td>{{ $schedulesData->remarks }}</td>
                        <td>{{ $schedulesData->status }}</td>
                        <td>
                            <a href="{{ route('schedule.edit', $schedulesData->id) }}" class="btn btn-bg-blue btn-sm">
                                <i class="bi bi-pen"></i>
                            </a>

                            {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                <i class="bi bi-eye"></i>
                            </a> --}}

                            <a href="{{ route('schedule.delete', $schedulesData->id) }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>

<script>
    document.getElementById('circleFilter').addEventListener('change', function() {
    var filterValue = this.value.toLowerCase();
    var tableRows = document.querySelectorAll('#scheduleTable tbody tr');

    tableRows.forEach(function(row) {
        var circleName = row.querySelector('.circle-name').textContent.toLowerCase();
        if (filterValue === "" || circleName.includes(filterValue)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
</script>

@endsection