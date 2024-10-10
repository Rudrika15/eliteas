@extends('layouts.master')

@section('header', 'Circle')
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <h5 class="card-title" style="color: #1d2856;">Report of {{ $circle->circleName }} Circle</h5>
                        <a href="{{ route('circle.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                @forelse ($circleCallsGrouped as $month => $totalMeetings)
                    <div class="col-md-4">
                        <!-- Circle Call Data -->
                        <div class="card shadow mb-3">
                            <div class="card-header">
                                <b style="color: #1d2856;">IBM - Month:
                                    {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</b>
                            </div>
                            <div class="card-body">
                                <p>Total Meetings: <b>{{ $totalMeetings }}</b></p>
                            </div>
                        </div>
                    </div>

                    <!-- Business Data (for the same month) -->
                    <div class="col-md-4">
                        @if (isset($businessMeetingsGrouped[$month]))
                            <div class="card shadow mb-3">
                                <div class="card-header">
                                    <b style="color: #1d2856;">Business - Month:
                                        {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</b>
                                </div>
                                <div class="card-body">
                                    <p>Total Amount:
                                        <b>₹ {{ number_format($businessMeetingsGrouped[$month]['totalAmount'], 2) }}</b>
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="card shadow mb-3">
                                <div class="card-header">
                                    <div class="card-body">
                                        No business data for {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- References Data (for the same month) -->
                    <div class="col-md-4">
                        @if (isset($referencesGrouped[$month]))
                            <div class="card shadow mb-3">
                                <div class="card-header">
                                    <b style="color: #1d2856;">Refferals - Month:
                                        {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</b>
                                </div>
                                <div class="card-body">
                                    <p>Total References: <b>{{ $referencesGrouped[$month]['count'] }}</b></p>
                                </div>
                            </div>
                        @else
                            <div class="card shadow mb-3">
                                <div class="card-header">
                                    <div class="card-body">
                                        No reference data for {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="card alert-info" role="alert">
                            <div class="card-header">
                                <b>No Data Found</b>
                            </div>
                            <div class="card-body">
                                No IBM, Business, or Reference data found.
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>










@endsection
