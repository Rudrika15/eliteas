@extends('layouts.master')

@section('header', 'IBM')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">IBM List</h4>

                </div>

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
                            @foreach ($ibms as $ibmData)
                                <tr>
                                    <th>{{ ($ibms->currentPage() - 1) * $ibms->perPage() + $loop->iteration }}</th>
                                    <td>{{ $ibmData->member->firstName ?? '-' }} {{ $ibmData->member->lastName ?? '-' }}
                                    </td>
                                    <td>{{ $ibmData->meetingPerson->firstName ?? '-' }}
                                        {{ $ibmData->meetingPerson->lastName ?? '-' }}</td>
                                    <td>{{ $ibmData->meetingPlace ?? '-' }}</td>
                                    <td>
                                        @if ($ibmData->meetingImage)
                                            <div class="meeting-image-wrapper" style="position: relative;">
                                                <img src="{{ url('meetingImage/' . basename($ibmData->meetingImage)) }}"
                                                    alt="Meeting Image"
                                                    style="width: 100px; height: auto; border-radius: 5px;"
                                                    onclick="openImage(this)">
                                                <div class="meeting-image-overlay" onclick="closeImage(event)">
                                                </div>
                                            </div>
                                        @else
                                            <span></span>
                                        @endif
                                    </td>

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
                                    <td>{{ $ibmData->date ?? '-' }}</td>
                                    <td>{{ $ibmData->remarks ?? '-' }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $ibms->links() !!}
                    </div>
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>

@endsection
