@extends('layouts.master')

@section('header', 'Circle')
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

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Circle</h4>
                <div class="">
                    <a href="{{ route('circle.create') }}" class="btn btn-bg-orange btn-sm mt-3 mr-2 "><i
                            class="bi bi-plus-circle"></i></a>
                    <a href="{{ route('schedule.index') }}" class="btn btn-bg-blue btn-sm mt-3">All Meetings</a>
                </div>
            </div>


            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Circle Name</th>
                            <th>Franchise Name</th>
                            <th>City Name</th>
                            <th>Circle Type</th>
                            <th>Meeting Day</th>
                            {{-- <th>Meeting Time</th> --}}
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($circle as $circleData)
                        <tr>
                            <td>{{$circleData->circleName}}</td>
                            <td>{{$circleData->franchise->franchiseName ?? '-'}}</td>
                            <td>{{$circleData->city->cityName ?? '-'}}</td>
                            <td>{{$circleData->circletype->circleTypeName ?? '-'}}</td>
                            <td>
                                {{-- Display name based on meeting day --}}
                                @if($circleData->meetingDay == 0)
                                Sunday
                                @elseif($circleData->meetingDay == 1)
                                Monday
                                @elseif($circleData->meetingDay == 2)
                                Tuesday
                                @elseif($circleData->meetingDay == 3)
                                Wednesday
                                @elseif($circleData->meetingDay == 4)
                                Thursday
                                @elseif($circleData->meetingDay == 5)
                                Friday
                                @elseif($circleData->meetingDay == 6)
                                Saturday
                                @else
                                -
                                @endif
                            </td>
                            {{-- <td>{{$circleData->meetingTime}}</td> --}}
                            <td>{{$circleData->status}}</td>
                            <td>

                                <a href="{{ route('meetings.by.circle', $circleData->id) }}"
                                    class="btn btn-bg-orange btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('circle.edit', $circleData->id) }}" class="btn btn-bg-blue btn-sm ">
                                    <i class="bi bi-pen"></i>
                                </a>

                                <a href="{{ route('circle.memberList', $circleData->id) }}"
                                    class="btn btn-info btn-sm ">
                                    <i class="bi bi-person-lines-fill"></i>
                                </a>

                                <a href="{{ route('circle.delete', $circleData->id) }}" class="btn btn-danger btn-sm ">
                                    <i class="bi bi-trash"></i>
                                </a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end" style="color: #1d3268">
                    {!! $circle->links() !!}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>
@endsection