@extends('layouts.master')

@section('header', 'Circle')
@section('content')

    <div class="row">
        <!-- Page Title and Back Button -->
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="card-body d-flex justify-content-between align-items-center ">
                        <h5 class="card-title" style="color: #1d2856;">Report of {{ $circle->circleName }} Circle</h5>
                        <a href="{{ route('circle.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
                    </div>
                </div>

                <!-- Date Filter Form -->
                <div class="col-md-12 mb-3 px-5 mt-3">
                    <form method="GET" action="{{ route('circle.report', $circle->id) }}">
                        <div class="row">
                            <!-- Start Date -->
                            <div class="col-md-3">
                                <label for="start_date" class="form-label"><b>Start Date</b></label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                    value="{{ $startDate ?? '' }}">
                            </div>

                            <!-- End Date -->
                            <div class="col-md-3">
                                <label for="end_date" class="form-label"><b>End Date</b></label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                    value="{{ $endDate ?? '' }}">
                            </div>

                            <!-- Filter Button -->
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-bg-blue">Filter</button>
                                <div style="width: 10px;"></div>
                                <a href="{{ route('circle.report', ['id' => $circle->id]) }}"
                                    class="btn btn-bg-orange">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Report Summary -->
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <h5 style="color: #1d2856;" class="mt-3"><b>Report
                            ({{ $startDate ? date('d-m-Y', strtotime($startDate)) : 'Start of Month' }} to
                            {{ $endDate ? date('d-m-Y', strtotime($endDate)) : 'Today' }})</b></h5>
                    <hr>
                    <div class="row">
                        <!-- Total IBM -->
                        <div class="col-md-4">
                            <div class="card gradient-orange-blue text-white mb-3">
                                <div class="card-header"><b>Total IBM</b></div>
                                <div class="card-body">
                                    <h5 class="card-title text-white">{{ $totalCircleCalls }}</h5>
                                    <p class="card-text">Circle calls during the selected date range.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Business Amount -->
                        <div class="col-md-4">
                            <div class="card gradient-orange-blue text-white mb-3">
                                <div class="card-header"><b>Total Business Amount</b></div>
                                <div class="card-body">
                                    <h5 class="card-title text-white">₹{{ number_format($totalBusinessAmount, 2) }}</h5>
                                    <p class="card-text">Business amount for the selected date range.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total References -->
                        <div class="col-md-4">
                            <div class="card gradient-orange-blue text-white mb-3">
                                <div class="card-header"><b>Total References</b></div>
                                <div class="card-body">
                                    <h5 class="card-title text-white">{{ $totalReferences }}</h5>
                                    <p class="card-text">References given during the selected date range.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
