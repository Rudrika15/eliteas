@extends('layouts.master')

@section('title', 'UBN - References')
@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Report of References</h4>
            </div>


            <form method="GET" action="{{ route('admin.report.reference') }}" id="dateFilterForm">
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
                <table class="table table-bordered table-striped table-hover" id="referencesTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Reference Giver Name</th>
                            <th>Reference Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($refrences as $index => $reference)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $reference['referenceGiverName'] }}</td>
                            <td>{{ $reference['reference_count'] }}</td>
                        </tr>
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

        document.getElementById('dateFilterForm').submit();
    });
</script>


@endsection