@extends('layouts.master')

@section('header', 'IBM Business Slip')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Business Slip List</h4>
                </div>

                <!-- Date Filter Form -->
                <form method="GET" action="{{ route('activity.businessesVp') }}" class="form-inline">
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
                            <button type="submit" class="btn btn-bg-blue mx-2">Filter</button>
                            <a href="{{ route('activity.businessesVp') }}" class="btn btn-bg-orange">Clear</a>
                        </div>
                </form>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Business By</th>
                            <th>Business To</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($businesses as $businessData)
                            <tr>
                                {{-- <th>{{ ($businesses->currentPage() - 1) * $businesses->perPage() + $loop->index + 1 }}</th> --}}
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $businessData->businessGiver->firstName ?? '-' }}
                                    {{ $businessData->businessGiver->lastName ?? '-' }}</td>
                                <td>{{ $businessData->loginMember->firstName ?? '-' }}
                                    {{ $businessData->loginMember->lastName ?? '-' }}</td>
                                <td>{{ $businessData->amount ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($businessData->created_at)->format('d-m-Y') ?? '-' }}</td>
                                <td>{{ $businessData->remarks ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {{-- {!! $businesses->links() !!} --}}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
    </div>

@endsection
