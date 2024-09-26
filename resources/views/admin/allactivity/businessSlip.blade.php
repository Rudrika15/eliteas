@extends('layouts.master')

@section('header', 'IBM')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Business Slip List</h4>

                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $businessData->businessGiver->firstName ?? '-' }}
                                        {{ $businessData->businessGiver->lastName ?? '-' }}</td>
                                    <td>{{ $businessData->loginMember->firstName ?? '-' }}
                                        {{ $businessData->loginMember->lastName ?? '-' }}</td>
                                    <td>{{ $businessData->amount ?? '-' }}</td>
                                    <td>{{ $businessData->date ?? '-' }}</td>
                                    <td>{{ $businessData->remarks ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $businesses->links() !!}
                    </div>
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>

@endsection
