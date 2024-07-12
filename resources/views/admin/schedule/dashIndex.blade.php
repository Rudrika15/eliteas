@extends('layouts.master')

@section('header', 'Franchise')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="justify-content-between align-items-center mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Next Upcoming Meetings</h4>
                <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm mt-3">BACK</a>
            {{-- <a href="{{ route('circle.index') }}" class="btn btn-primary btn-sm mt-3">BACK</a> --}}
        </div>

        <!-- Table with stripped rows -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Circle Name</th>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Venue</th>
                    <th>Time</th>
                    <th>Remarks</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                $closestMeetings = [];
                @endphp
                @foreach ($schedules as $schedulesData)
                @php
                $scheduleDate = \Carbon\Carbon::parse($schedulesData->date);

                if ($scheduleDate->isToday() || $scheduleDate->isFuture()) {

                $circleId = $schedulesData->circle->id;
                if (!isset($closestMeetings[$circleId]) ||

                $scheduleDate->lt($closestMeetings[$circleId]['date'])) {

                $closestMeetings[$circleId] = [

                'data' => $schedulesData,

                'date' => $scheduleDate,
                ];
                }
                }
                @endphp
                @endforeach

                @foreach ($closestMeetings as $meeting)
                <tr>
                    <td>{{$meeting['data']->circle->circleName}}</td>
                    <td>
                        @php
                        $dayIndex = $meeting['data']->day;
                        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        $dayName = isset($days[$dayIndex]) ? $days[$dayIndex] : '-';
                        @endphp
                        {{$dayName}}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($meeting['data']->date)->format('d-m-Y') }}</td>
                    <td>{{$meeting['data']->venue}}</td>
                    <td>{{$meeting['data']->meetingTime}}</td>
                    <td>{{$meeting['data']->remarks}}</td>
                    {{-- <td>{{$meeting['data']->status}}</td> --}}
                    <td>
                        <a href="{{ route('schedule.invitedList', $meeting['data']->id) }}" class="btn btn-info btn-sm btn-tooltip">
                            <i class="bi bi-person-lines-fill"></i>
                            <span class="btn-text">View Invited Peoples</span>
                        </a>

                        <a href="{{ route('schedule.dashEdit', $meeting['data']->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                            <i class="bi bi-pen"></i>
                            <span class="btn-text">Edit</span>
                        </a>

                        {{-- <a href="{{ route('schedule.delete', $meeting['data']->id) }}"
                            class="btn btn-danger btn-sm btn-tooltip">
                            <i class="bi bi-trash"></i>
                            <span class="btn-text">Delete</span>
                        </a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection