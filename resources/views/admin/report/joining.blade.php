@extends('layouts.master')

@section('title', 'UBN - Joining Members Report')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Joining Members Report</h4>
                </div>

                <div class="row mb-3">
                    <div>
                        <form method="GET" action="{{ route('admin.report.joining') }}" id="dateFilterForm">
                            <div class="row mb-3 align-items-end">

                                <!-- From Date -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted"><strong>From</strong></label>
                                    <input type="date" name="startDate" id="startDate" class="form-control form-control-sm" value="{{ request('startDate') }}">
                                </div>

                                <!-- To Date -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted"><strong>To</strong></label>
                                    <input type="date" name="endDate" id="endDate" class="form-control form-control-sm" value="{{ request('endDate') }}">
                                </div>

                                <!-- Status -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted"><strong>Status</strong></label>
                                    <select name="status" id="status" class="form-control form-control-sm">
                                        <option value="">All</option>
                                        <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Deleted" {{ request('status') == 'Deleted' ? 'selected' : '' }}>Deleted</option>
                                    </select>
                                </div>

                                <!-- Buttons -->
                                <div class="col-md-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-bg-blue btn-sm w-50">Submit</button>
                                    <button type="button" class="btn btn-bg-orange btn-sm w-50" id="resetButton">Reset</button>
                                </div>

                            </div>

                        </form>
                    </div>
                    {{-- <div class="col-md-4">
                        <form method="GET" action="{{ route('admin.report.joining') }}" id="circleFilterForm">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="circleId" class="form-label">Select Circle</label>
                                    <select name="circleId" id="circleId" class="form-control form-control-sm">
                                        <option value="">-- Select Circle --</option>
                                        @foreach ($circles as $circle)
                                            <option value="{{ is_string($circle) ? $circle : $circle->id }}" {{ request()->input('circleId') == (is_string($circle) ? $circle : $circle->id) ? 'selected' : '' }}>
                                                {{ is_string($circle) ? $circle : $circle->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mb-3">
                                <button type="submit" class="btn btn-bg-blue btn-sm">Submit</button>
                            </div>
                        </form>
                    </div> --}}
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="membersTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Circle Name / Member Name</th>
                                <th>Member Count / Joining Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $index => $item)
                                {{-- Main Circle Row --}}
                                <tr class="table-primary">
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item['circleName'] }}</strong></td>
                                    <td><strong>{{ $item['member_count'] }}</strong></td>
                                </tr>

                                {{-- Member Rows --}}
                                @foreach ($item['member_list'] as $member)
                                    <tr>
                                        <td></td>
                                        <td class="ps-4">→ {{ $member['full_name'] }}</td>
                                        <td>{{ $member['joined_date'] }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>

    <script>
        document.getElementById('resetButton').addEventListener('click', function() {
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            document.getElementById('circleId').value = '';
            document.getElementById('dateFilterForm').submit();
        });
    </script>

@endsection
