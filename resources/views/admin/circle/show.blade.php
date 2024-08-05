@extends('layouts.master')

@section('header', 'Franchise')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Meetings</h4>
            <a href="{{ route('circle.index') }}" class="btn btn-bg-orange btn-sm mt-3">BACK</a>
        </div>

        <!-- Generate Meetings Button -->
        <div class="d-flex justify-content-end mb-3">
            <form action="{{ route('schedule.generate', $circle->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-bg-blue">
                    <i class="bi bi-calendar-plus"></i> <!-- Bootstrap Icon for Calendar Plus -->
                    Generate Meetings for Next Month
                </button>
            </form>
        </div>
        <!-- End Generate Meetings Button -->

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                        <td>{{$schedulesData->circle->circleName}}</td>
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
                        <td>{{ \Carbon\Carbon::parse($schedulesData->date)->format('d-m-Y') }}</td>
                        {{-- <td>{{$schedulesData->date}}</td> --}}
                        <td>{{$schedulesData->venue}}</td>
                        <td>{{$schedulesData->meetingTime}}</td>
                        <td>{{$schedulesData->remarks}}</td>
                        <td>{{$schedulesData->status}}</td>
                        <td>
                            <a href="{{ route('schedule.invitedList', $schedulesData->id) }}"
                                class="btn btn-info btn-sm btn-tooltip">
                                <i class="bi bi-person-lines-fill"></i>
                                <span class="btn-text">View Invited Peoples</span>
                            </a>

                            <a href="{{ route('schedule.edit', $schedulesData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                <i class="bi bi-pen"></i>
                                <span class="btn-text">Edit</span>
                            </a>

                            {{-- <a href="{{ route('schedule.delete', $schedulesData->id) }}" class="btn btn-danger btn-tooltip btn-sm">
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
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>

@endsection