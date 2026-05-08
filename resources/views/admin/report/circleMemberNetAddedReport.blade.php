@extends('layouts.master')

@section('title', 'UBN - Circle Member Net Added Report')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Circle Member Net Added Report</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.report.circleMemberNetAdded', ['export' => 'excel', 'month' => request('month'), 'circleId' => request('circleId')]) }}" class="btn btn-success btn-sm">
                            Export Excel
                        </a>

                    </div>
                </div>

                <!-- Filters -->
                <form method="GET" action="{{ route('admin.report.circleMemberNetAdded') }}" id="dateFilterForm">
                    <div class="row mb-3 align-items-end">

                        <div class="col-md-4">
                            <small class="text-muted"><strong>Month:</strong></small>
                            <input type="month" name="month" id="month" class="form-control form-control-sm" value="{{ request('month') }}">
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted"><strong>Circle:</strong></small>
                            <select name="circleId" id="circleId" class="form-control form-control-sm">
                                <option value="">All Circles</option>
                                @foreach ($circles as $circle)
                                    <option value="{{ $circle->id }}" {{ request('circleId') == $circle->id ? 'selected' : '' }}>
                                        {{ $circle->circleName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <div class="d-flex w-100 gap-2">
                                <button type="submit" class="btn btn-bg-blue btn-sm w-50">Submit</button>
                                <button type="button" class="btn btn-bg-orange btn-sm w-50" id="resetButton">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">

                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Circle Name</th>
                                <th>Last Month Count</th>
                                <th>Current Month Added</th>
                                <th>Current Month Removed</th>
                                <th>Net Count</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($report as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row['circleName'] }}</td>
                                    <td>{{ $row['last_month_members'] }}</td>
                                    <td>{{ $row['current_added'] }}</td>
                                    <td>{{ $row['current_deleted'] }}</td>
                                    <td>
                                        <strong>
                                            {{ $row['net_change'] }}
                                        </strong>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Reset Script -->
    <script>
        document.getElementById('resetButton').addEventListener('click', function() {
            document.getElementById('month').value = '';
            document.getElementById('circleId').value = '';
            document.getElementById('dateFilterForm').submit();
        });
    </script>

@endsection
