@extends('layouts.master')

@section('header', 'IBM References')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">References List</h4>
                </div>

                <!-- Date Filter Form -->
                <form method="GET" action="{{ route('activity.refrenceVp') }}" class="form-inline">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="start_date"><b>Start Date</b></label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date"><b>End Date</b></label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-bg-blue mx-2">Filter</button>
                            <a href="{{ route('activity.refrenceVp') }}" class="btn btn-bg-orange">Clear</a>
                        </div>
                </form>

                <!-- Table with stripped rows -->
                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Date</th>
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
                                    {{-- <th>{{ ($refrences->currentPage() - 1) * $refrences->perPage() + $loop->index + 1 }}
                                    </th> --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($refrenceData->created_at)->format('d-m-Y') }}</td>
                                    <td>{{ $refrenceData->refGiverName->firstName ?? '-' }}
                                        {{ $refrenceData->refGiverName->lastName ?? '-' }}</td>
                                    <td>{{ $refrenceData->members->firstName ?? '-' }}
                                        {{ $refrenceData->members->lastName ?? '-' }}</td>
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
                        {{-- {!! $refrences->links() !!} --}}
                    </div>
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>

@endsection
