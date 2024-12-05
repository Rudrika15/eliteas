@extends('layouts.master')

@section('title', 'UBN - Business Report')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Business Report</h4>
            </div>

            <form method="GET" action="{{ route('admin.report.business') }}" id="dateFilterForm">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <small class="text-muted me-1"><strong>From:</strong></small><br>
                        <div class="d-flex align-items-center">
                            <input type="date" name="startDate" id="startDate" class="form-control form-control-sm"
                                value="{{ request()->input('startDate') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted me-1"><strong>To:</strong></small><br>
                        <div class="d-flex align-items-center">
                            <input type="date" name="endDate" id="endDate" class="form-control form-control-sm"
                                value="{{ request()->input('endDate') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-3">

                    <button type="submit" class="btn btn-bg-blue btn-sm">Submit</button>

                    <button type="button" class="btn btn-bg-orange btn-sm ms-2" id="resetButton">Reset</button>
                </div>
            </form>


            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="businessTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Business Count</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($business as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['businessGiver'] }}</td>
                            <td>{{ $item['business_count'] }}</td>
                            <td>{{ number_format($item['total_amount'], 2) }}</td>
                        </tr>
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

        document.getElementById('dateFilterForm').submit();
    });
</script>

@endsection