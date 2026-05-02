@extends('layouts.master')

@section('title', 'UBN - Circle Member Report')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Circle Member Report</h4>
                    <div class="d-flex gap-2">
                        <form method="GET" action="{{ route('admin.report.circleMember') }}">
                            <input type="hidden" name="circleId" value="{{ request()->input('circleId') }}">
                            <input type="hidden" name="startDate" value="{{ request()->input('startDate') }}">
                            <input type="hidden" name="endDate" value="{{ request()->input('endDate') }}">
                            <button type="submit" name="export" value="1" class="btn btn-success btn-sm">Export
                                Summary</button>
                        </form>
                        <form method="GET" action="{{ route('admin.report.circleMember') }}">
                            <input type="hidden" name="circleId" value="{{ request()->input('circleId') }}">
                            <input type="hidden" name="startDate" value="{{ request()->input('startDate') }}">
                            <input type="hidden" name="endDate" value="{{ request()->input('endDate') }}">
                            <button type="submit" name="export" value="detail" class="btn btn-primary btn-sm">Export
                                Detailed</button>
                        </form>
                    </div>
                </div>

                <form method="GET" action="{{ route('admin.report.circleMember') }}" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small class="text-muted me-1"><strong>From:</strong></small><br>
                            <input type="date" name="startDate" id="startDate" class="form-control form-control-sm" value="{{ request()->input('startDate') }}">
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted me-1"><strong>To:</strong></small><br>
                            <input type="date" name="endDate" id="endDate" class="form-control form-control-sm" value="{{ request()->input('endDate') }}">
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted me-1"><strong>Circle:</strong></small><br>
                            <select name="circleId" id="circleId" class="form-control form-control-sm">
                                <option value="">Select Circle</option>
                                @foreach ($circles as $circle)
                                    <option value="{{ $circle->id }}" {{ request()->input('circleId') == $circle->id ? 'selected' : '' }}>
                                        {{ $circle->circleName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <button type="submit" class="btn btn-bg-blue btn-sm">Submit</button>
                        <button type="button" class="btn btn-bg-orange btn-sm ms-2" id="resetButton">Reset</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Circle</th>
                                <th>Member Name</th>
                                {{-- <th>Member User ID</th> --}}
                                <th>IBM Count</th>
                                <th>Reference Count</th>
                                <th>Business Count</th>
                                <th>Total Business Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row['circleName'] }}</td>
                                    <td>{{ $row['memberName'] }}</td>
                                    {{-- <td>{{ $row['memberUserId'] }}</td> --}}
                                    <td>{{ $row['ibm_count'] }}</td>
                                    <td>{{ $row['reference_count'] }}</td>
                                    <td>{{ $row['business_count'] }}</td>
                                    <td>{{ number_format($row['business_total_amount'], 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if (!empty($details) && count($report) > 0)
                    <div class="accordion mt-4" id="memberDetailsAccordion">
                        @foreach ($report as $index => $row)
                            @php
                                $uid = $row['memberUserId'];
                                $det = $details[$uid] ?? ['ibms' => [], 'references' => [], 'businesses' => []];
                            @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $uid }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $uid }}" aria-expanded="false" aria-controls="collapse-{{ $uid }}">
                                        {{ $row['memberName'] }} ({{ $row['circleName'] }})
                                    </button>
                                </h2>
                                <div id="collapse-{{ $uid }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $uid }}" data-bs-parent="#memberDetailsAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6>IBM</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>With Member</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($det['ibms'] as $r)
                                                                <tr>
                                                                    <td>{{ $r['with_name'] }}</td>
                                                                    <td>{{ $r['date'] }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="2" class="text-center">No data</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6>Business</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>To Member</th>
                                                                <th>Amount</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($det['businesses'] as $r)
                                                                <tr>
                                                                    <td>{{ $r['to_name'] }}</td>
                                                                    <td>{{ number_format($r['amount'], 2) }}</td>
                                                                    <td>{{ $r['date'] }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center">No data</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h6>Reference</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>To Member</th>
                                                                <th>Other Person</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($det['references'] as $r)
                                                                <tr>
                                                                    <td>{{ $r['to_name'] }}</td>
                                                                    <td>{{ $r['contact_name'] }}</td>
                                                                    <td>{{ $r['date'] }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="3" class="text-center">No data</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

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
