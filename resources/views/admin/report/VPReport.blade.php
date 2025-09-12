@extends('layouts.master')

@section('content')
<div class="container my-4">
    <div class="card shadow-sm border-0">
        <div class="card-body mt-3">
            <h2 class="mb-3 bg-primary-light p-2 rounded" style="color:#1d3268;">
                Circle Report - <span class="fw-bold">{{ $circle->circleName }}</span>
            </h2>

            {{-- Filter Section --}}
            <form method="GET" action="{{ route('vp.report') }}" class="mb-4">
                <div class="row g-3 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="startDate" class="form-control" value="{{ $startDate }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="endDate" class="form-control" value="{{ $endDate }}">
                    </div>
                    <div class="col-md-6 d-flex gap-2 mt-4 justify-content-end">
                        <button type="submit" class="btn text-white" style="background:#1d3268;">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <a href="{{ route('vp.report.export', request()->all()) }}" class="btn text-white" style="background:#e76a35;">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                </div>
            </form>

            {{-- Summary Section --}}
            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <div class="p-3 rounded shadow-sm border" style="background:#f8f9fa;">
                        <h6 class="text-muted">Total Circle Calls</h6>
                        <h3 class="fw-bold" style="color:#1d3268;">{{ $totalCircleCalls }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded shadow-sm border" style="background:#f8f9fa;">
                        <h6 class="text-muted">Total References</h6>
                        <h3 class="fw-bold" style="color:#e76a35;">{{ $totalReferences }}</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded shadow-sm border" style="background:#f8f9fa;">
                        <h6 class="text-muted">Total Business Amount</h6>
                        <h3 class="fw-bold" style="color:#1d3268;">₹{{ number_format($totalBusinessAmount, 2) }}</h3>
                    </div>
                </div>
            </div>

            {{-- IBM Report --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header text-white fw-bold" style="background:#1d3268;">IBM Report</div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead style="background:#eaeaea;">
                            <tr>
                                <th>Member</th>
                                {{-- <th>Circle</th> --}}
                                <th>IBM</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ibms as $row)
                            <tr>
                                <td>{{ $row['memberName'] }}</td>
                                {{-- <td>{{ $row['circleName'] }}</td> --}}
                                <td class="fw-bold" style="color:#1d3268;">{{ $row['member_count'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- References Report --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header text-white fw-bold" style="background:#e76a35;">References Report</div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead style="background:#eaeaea;">
                            <tr>
                                <th>Reference Giver</th>
                                <th>References</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($refReport as $row)
                            <tr>
                                <td>{{ $row['referenceGiverName'] }}</td>
                                <td class="fw-bold" style="color:#e76a35;">{{ $row['reference_count'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Business Report --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header text-white fw-bold" style="background:#1d3268;">Business Report</div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead style="background:#eaeaea;">
                            <tr>
                                <th>Business Giver</th>
                                {{-- <th>Business Count</th> --}}
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($businessReport as $row)
                            <tr>
                                <td>{{ $row['member'] }}</td>
                                {{-- <td class="fw-bold" style="color:#e76a35;">{{ $row['business_count'] }}</td> --}}
                                <td class="fw-bold" style="color:#1d3268;">₹{{ number_format($row['total_amount'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
