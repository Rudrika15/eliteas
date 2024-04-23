@extends('layouts.master')

@section('header', 'Franchise')
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
            <h4 class="mb-0 mt-3">Schedule</h4>
            <a href="{{ route('circle.index') }}" class="btn btn-primary btn-sm mt-3">BACK</a>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
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
                    <td>{{$schedulesData->date}}</td>
                    <td>{{$schedulesData->venue}}</td>
                    <td>{{$schedulesData->meetingTime}}</td>
                    <td>{{$schedulesData->remarks}}</td>
                    <td>{{$schedulesData->status}}</td>
                    <td>
                        <a href="{{ route('schedule.edit', $schedulesData->id) }}" class="btn btn-primary btn-sm ">
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
    @endsection