@extends('layouts.master')

@section('content')


    <div class="container">
        <div class="card mb-5">

            <h1 class="p-3" style="color: #1d3268"><b>Leaderboard</b></h1>

            <!-- Circle Dropdown -->
            <form method="GET" action="{{ route('circleWiseLeaderboard.index') }}">
                <div class="form-group mb-3 p-3">
                    <label for="circleId"><b>Select Circle:</b></label>
                    <select name="circleId" id="circleId" class="form-control" onchange="this.form.submit()">
                        <option value="" disabled>-- Select Circle --</option>
                        @foreach ($circles as $circle)
                            <option value="{{ $circle->id }}" {{ $selectedCircleId == $circle->id ? 'selected' : '' }}>
                                {{ $circle->circleName }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Circle Calls Section -->
        @if ($circlecalls && $circlecalls->isNotEmpty())
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($circlecalls as $call)
                    <div class="col-md-4 mt-6">
                        <div class="profile-card">
                            <div class="card-body">
                                @php
                                    $profilePhoto = $call['member']->profilePhoto ?? 'profile.png';
                                @endphp
                                <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" alt="Profile Photo" class="profile-img mb-3">
                                <p class="profile-title mb-3">Max IBMs</p>
                                <h3 class="profile-name mb-3">{{ $call['member']->firstName }} {{ $call['member']->lastName }}</h3>
                                <p style="font-size: 14px; color: #1d3268;">Circle: <b>{{ $call['member']->circle->circleName }}</b></p>
                                <p style="font-size: 14px; color: #1d3268;">Total IBMs: <b>{{ $call['count'] }}</b></p>
                            </div>
                        </div>
                @endforeach
            </div>
        @else
            <p>No circle calls data available for the selected circle.</p>
        @endif

        <!-- Business Givers Section -->
        @if ($busGiver && $busGiver->isNotEmpty())
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($busGiver as $giver)
                    <div class="col">
                        <div class="profile-card">
                            <div class="card-body">
                                @php
                                    $profilePhoto = $giver['member']->profilePhoto ?? 'profile.png';
                                @endphp
                                <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" alt="Profile Photo" class="profile-img mb-3">
                                <p class="profile-title mb-3">Max Business Leader</p>
                                <h3 class="profile-name mb-3">{{ $giver['user']->firstName }} {{ $giver['user']->lastName }}</h3>
                                <p style="font-size: 14px; color: #1d3268;">Circle: <b>{{ $giver['circle']->circleName ?? 'N/A' }}</b></p>
                                <p style="font-size: 14px; color: #1d3268;">Amount: <b>{{ $giver['amount'] }}</b></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No business givers data available for the selected circle.</p>
        @endif

        <!-- Reference Givers Section -->
        @if ($refGiver && $refGiver->isNotEmpty())
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($refGiver as $giver)
                    <div class="col">
                        <div class="profile-card">
                            <div class="card-body">
                                @php
                                    $profilePhoto = 'profile.png'; // Default profile photo for reference givers
                                @endphp
                                <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" alt="Profile Photo" class="profile-img mb-3">
                                <p class="profile-title mb-3">Top Reference Giver</p>
                                <h3 class="profile-name mb-3">{{ $giver['user']->firstName }} {{ $giver['user']->lastName }}</h3>
                                <p style="font-size: 14px; color: #1d3268;">Circle: <b>{{ $giver['circle']->circleName ?? 'N/A' }}</b></p>
                                <p style="font-size: 14px; color: #1d3268;">References Count: <b>{{ $giver['count'] }}</b></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
@else
    <p>No reference givers data available for the selected circle.</p>
    @endif
    </div>


    <style>
        .profile-card {
            width: 250px;
            height: 300px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: auto;
            padding: 15px 0;
            position: relative;
            border: 2px solid #e76a35;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #1d3268;
        }

        .profile-title {
            font-size: 14px;
            font-weight: bold;
            color: #e76a35;
            margin-bottom: 5px;
        }

        .profile-name {
            font-size: 16px;
            font-weight: bold;
            color: #1d3268;
            margin-bottom: 5px;
        }

            {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>


@endsection
