@extends('layouts.master')

@section('title', 'UBN - Joining Members Report')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Renewal / Joining Members Report</h4>
                </div>

                <form method="GET" action="{{ route('admin.report.renewal') }}" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted me-1"><strong>From:</strong></small><br>
                                    <div class="d-flex align-items-center">
                                        <input type="date" name="startDate" id="startDate" class="form-control form-control-sm" value="{{ request()->input('startDate') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted me-1"><strong>To:</strong></small><br>
                                    <div class="d-flex align-items-center">
                                        <input type="date" name="endDate" id="endDate" class="form-control form-control-sm" value="{{ request()->input('endDate') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted me-1"><strong>Select Circle:</strong></small><br>
                            <select name="circleId" id="circleId" class="form-control form-control-sm">
                                <option value="">-- All Circles --</option>
                                @foreach ($circles as $id => $name)
                                    <option value="{{ $id }}" {{ request()->input('circleId') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-bg-blue btn-sm">Submit</button>
                            <button type="submit" formaction="{{ route('admin.report.renewal.export') }}" class="btn btn-success btn-sm ms-2">Export Excel</button>
                            <button type="button" class="btn btn-bg-orange btn-sm ms-2" id="resetButton">Reset</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="membersTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Circle Name / Member Name</th>
                                <th>Member Count / Joining Date</th>
                                <th>Member Count / Renewal Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($members as $index => $item)
                                {{-- Main Circle Row --}}
                                <tr class="table-primary">
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $item['circleName'] }}</strong></td>
                                    <td><strong>{{ $item['member_count'] }}</strong></td>
                                    <td><strong>{{ $item['member_count'] }}</strong></td>
                                </tr>

                                {{-- Member Rows --}}
                                @foreach ($item['member_list'] as $member)
                                    <tr>
                                        <td></td>
                                        <td class="ps-4">→ {{ $member['full_name'] }}</td>
                                        <td>{{ $member['joined_date'] }}</td>
                                        <td>{{ $member['renewal_date'] }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No data found</td>
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
            document.getElementById('filterForm').submit();
        });
    </script>

@endsection
