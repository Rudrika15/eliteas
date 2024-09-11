@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Leaderboard</h1>

    <!-- Circle Dropdown -->
    <form method="GET" action="{{ route('circleWiseLeaderboard.index') }}">
        <div class="form-group">
            <label for="circleId">Select Circle:</label>
            <select name="circleId" id="circleId" class="form-control" onchange="this.form.submit()">
                <option value="">-- Select Circle --</option>
                @foreach($circles as $circle)
                <option value="{{ $circle->id }}" {{ $selectedCircleId==$circle->id ? 'selected' : '' }}>
                    {{ $circle->circleName }}
                </option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Circle Calls Section -->
    @if($circlecalls && $circlecalls->isNotEmpty())
    <div class="row mt-5">
        @foreach($circlecalls as $call)
        <div class="col-md-3 mb-4">
            <div class="card">
                @php
                $profilePhoto = $call['member']->profilePhoto ?? 'profile.png';
                @endphp
                <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" class="card-img-top" alt="Profile Photo">
                <div class="card-body text-center">
                    <h5 class="card-title">Max Business Meetscircle</h5>
                    <p class="card-text">
                        <span style="font-size: 18px; color: #e76a35; font-weight: bold;">
                            {{ $call['member']->firstName }} {{ $call['member']->lastName }}<br>
                        </span>
                        <hr class="my-2" style="color: #e76a35; width: 30%;">
                    <div>
                        <span style="font-size: 14px; color: #e76a35; font-weight: bold;">
                            Circle: {{ $call['member']->circle->circleName }}
                        </span><br>
                        <span style="font-size: 12px; color: #e76a35; font-weight: bold;">
                            Calls Count: {{ $call['count'] }}
                        </span>
                    </div>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
        {{--
    </div> --}}
    @else
    <p>No circle calls data available for the selected circle.</p>
    @endif

    <!-- Business Givers Section -->
    @if($busGiver && $busGiver->isNotEmpty())
    {{-- <div class="row"> --}}
        @foreach($busGiver as $giver)
        <div class="col-md-3 mb-4">
            <div class="card">
                @php
                $profilePhoto = $giver['user']->profilePhoto ?? 'profile.png';
                @endphp
                <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" class="card-img-top" alt="Profile Photo">
                <div class="card-body text-center">
                    <h5 class="card-title">Max Business Leader</h5>
                    <p class="card-text">
                        <span style="font-size: 18px; color: #e76a35; font-weight: bold;">
                            {{ $giver['user']->firstName }} {{ $giver['user']->lastName }}<br>
                        </span>
                        <hr class="my-2" style="color: #e76a35; width: 30%;">
                    <div>
                        <span style="font-size: 14px; color: #e76a35; font-weight: bold;">
                            Circle: {{ $giver['circle']->circleName ?? 'N/A' }}
                        </span><br>
                        <span style="font-size: 12px; color: #e76a35; font-weight: bold;">
                            Meetings Count: {{ $giver['count'] }}<br>
                            Amount: {{ $giver['amount'] }}
                        </span>
                    </div>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
        {{--
    </div> --}}
    @else
    <p>No business givers data available for the selected circle.</p>
    @endif

    <!-- Reference Givers Section -->
    @if($refGiver && $refGiver->isNotEmpty())
    {{-- <div class="row"> --}}
        @foreach($refGiver as $giver)
        <div class="col-md-3 mb-4">
            <div class="card">
                @php
                $profilePhoto = 'profile.png'; // Default profile photo for reference givers
                @endphp
                <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" class="card-img-top" alt="Profile Photo">
                <div class="card-body text-center">
                    <h5 class="card-title">Max References</h5>
                    <p class="card-text">
                        <span style="font-size: 18px; color: #e76a35; font-weight: bold;">
                            {{ $giver['user']->firstName }} {{ $giver['user']->lastName }}<br>
                        </span>
                        <hr class="my-2" style="color: #e76a35; width: 30%;">
                    <div>
                        <span style="font-size: 14px; color: #e76a35; font-weight: bold;">
                            Circle: {{ $giver['circle']->circleName ?? 'N/A' }}
                        </span><br>
                        <span style="font-size: 12px; color: #e76a35; font-weight: bold;">
                            References Count: {{ $giver['count'] }}
                        </span>
                    </div>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>No reference givers data available for the selected circle.</p>
    @endif
</div>
@endsection