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

                <h5 class="mt-3 mb-2">Circle Activity</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($circleActivityData as $data)
                                <tr>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center">No data found or no circle assigned.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h5 class="mt-4 mb-2">Attendance</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Member Name</th>
                                <th>P - Presence</th>
                                <th>A - Absent</th>
                                <th>L - Late</th>
                                <th>M - Medical</th>
                                <th>S - Substitute</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendanceData as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['member_name'] }}</td>
                                    <td>{{ $data['present'] }}</td>
                                    <td>{{ $data['absent'] }}</td>
                                    <td>{{ $data['late'] }}</td>
                                    <td>{{ $data['medical'] }}</td>
                                    <td>{{ $data['substitute'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No data found or no circle assigned.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
