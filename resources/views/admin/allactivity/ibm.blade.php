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
                    <table class="table table-striped table-hover">
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ibmData->member->firstName ?? '-' }} {{ $ibmData->member->lastName ?? '-' }}</td>
                                    <td>{{ $ibmData->meetingPerson->firstName ?? '-' }} {{ $ibmData->meetingPerson->lastName ?? '-' }}</td>
                                    <td>{{ $ibmData->meetingPlace ?? '-' }}</td>
                                    <td>{{ $ibmData->meetingImage ?? '-' }}</td>
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
