@extends('layouts.master')

@section('header', 'IBM')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">IBM List</h4>
                </div>

                <!-- Date Filter Form -->
                <form method="GET" action="{{ route('activity.ibmVp') }}">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="start_date"><b>Start Date</b></label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request()->start_date }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date"><b>End Date</b></label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request()->end_date }}">
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-bg-blue">Filter</button>
                            <a href="{{ route('activity.ibmVp') }}" class="btn btn-bg-orange">Clear</a>
                        </div>
                    </div>
                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Meeting By</th>
                                <th>Meeting With</th>
                                <th>Meeting Place</th>
                                <th>Meeting Image</th>
                                <th>Meeting Date</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($circlecalls as $circlecallsData)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $circlecallsData->member->firstName ?? '-' }}
                                        {{ $circlecallsData->member->lastName ?? '-' }}</td>
                                    <td>{{ $circlecallsData->meetingPerson->firstName ?? '-' }}
                                        {{ $circlecallsData->meetingPerson->lastName ?? '-' }}</td>
                                    <td>{{ $circlecallsData->meetingPlace ?? '-' }}</td>
                                    <td>
                                        @if ($circlecallsData->meetingImage)
                                            <div class="meeting-image-wrapper" style="position: relative;">
                                                <img src="{{ url('meetingImage/' . basename($circlecallsData->meetingImage)) }}"
                                                    alt="Meeting Image"
                                                    style="width: 100px; height: auto; border-radius: 5px;"
                                                    onclick="openImage(this)">
                                                <div class="meeting-image-overlay" onclick="closeImage(event)"></div>
                                            </div>
                                        @else
                                            <span></span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($circlecallsData->date)->format('d-m-Y') ?? '-' }}</td>
                                    <td>{{ $circlecallsData->remarks ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {{-- {!! $circlecalls->links() !!} --}}
                    </div>
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>

    <!-- Script for handling image modals -->
    <script>
        function openImage(img) {
            img.parentElement.classList.add('active');
            var overlay = img.parentElement.querySelector('.meeting-image-overlay');
            overlay.style.backgroundImage = "url('" + img.src + "')";
        }

        function closeImage(event) {
            if (event.target.classList.contains('meeting-image-overlay')) {
                event.target.parentElement.classList.remove('active');
            }
        }
    </script>

    <!-- Styles for modal image display -->
    <style>
        .meeting-image-wrapper {
            position: relative;
        }

        .meeting-image-wrapper.active .meeting-image-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            z-index: 1000;
        }
    </style>

@endsection
