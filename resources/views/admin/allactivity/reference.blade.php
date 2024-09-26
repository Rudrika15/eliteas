@extends('layouts.master')

@section('header', 'IBM')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Refrences List</h4>

                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Reference By</th>
                                <th>Reference To</th>
                                <th>Contact Name</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>Scale</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($refrences as $refrenceData)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $refrenceData->members->firstName ?? '-' }}
                                        {{ $refrenceData->members->lastName ?? '-' }}</td>
                                    <td>{{ $refrenceData->refGiverName->firstName ?? '-' }}
                                        {{ $refrenceData->refGiverName->lastName ?? '-' }}</td>
                                    <td>{{ $refrenceData->contactName ?? '-' }}</td>
                                    <td>{{ $refrenceData->contactNo ?? '-' }}</td>
                                    <td>{{ $refrenceData->email ?? '-' }}</td>
                                    <td>{{ $refrenceData->scale ?? '-' }}</td>
                                    <td>{{ $refrenceData->description ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $refrences->links() !!}
                    </div>
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>

@endsection
