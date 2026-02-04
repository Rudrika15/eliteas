@extends('layouts.master')

@section('title', 'UBN - Circle & Attendance Report')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Circle & Attendance Report</h4>
                    <div>
                        <form method="GET" action="{{ route('admin.report.circleAttendanceCombined') }}">
                            <input type="hidden" name="start_date" value="{{ request()->input('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request()->input('end_date') }}">
                            <button type="submit" name="export" value="1" class="btn btn-success btn-sm">Export Excel</button>
                        </form>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.report.circleAttendanceCombined') }}" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request()->input('start_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request()->input('end_date') }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('admin.report.circleAttendanceCombined') }}" class="btn btn-secondary ms-2">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Member Name</th>
                                <th>IBM</th>
                                <th>Ref Given (In)</th>
                                <th>Ref Given (Out)</th>
                                <th>Ref Rec (In)</th>
                                <th>Ref Rec (Out)</th>
                                <th>Bus Given</th>
                                <th>Bus Rec</th>
                                <th>Training</th>
                                <th>Testimonial Given</th>
                                <th>Testimonial Rec</th>
                                <th>P</th>
                                <th>A</th>
                                <th>L</th>
                                <th>M</th>
                                <th>S</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reportData as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['member_name'] }}</td>
                                    <td>{{ $data['ibm'] }}</td>
                                    <td>{{ $data['ref_given_inside'] }}</td>
                                    <td>{{ $data['ref_given_outside'] }}</td>
                                    <td>{{ $data['ref_received_inside'] }}</td>
                                    <td>{{ $data['ref_received_outside'] }}</td>
                                    <td>{{ $data['business_given'] }}</td>
                                    <td>{{ $data['business_received'] }}</td>
                                    <td>{{ $data['training'] }}</td>
                                    <td>{{ $data['testimonial_given'] }}</td>
                                    <td>{{ $data['testimonial_received'] }}</td>
                                    <td>{{ $data['present'] }}</td>
                                    <td>{{ $data['absent'] }}</td>
                                    <td>{{ $data['late'] }}</td>
                                    <td>{{ $data['medical'] }}</td>
                                    <td>{{ $data['substitute'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="17" class="text-center">No data found or no circle assigned.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
