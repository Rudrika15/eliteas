@extends('layouts.masterVisitor')

@section('header', 'View Members')
@section('content')

<style>
    .card-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        background-color: #fff;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 0 auto 15px;
    background-color: #e1e9ee;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #1d3268;
    overflow: hidden;
    border: 4px solid #e76a35; /* WhatsApp green border color */
}

.profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
    .card-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
        color: #1d3268;
        cursor: pointer;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-view-profile, .btn-slot-booking {
        background-color: #e76a35 ;
        color: #fff !important;
        border-radius: 5px;
        padding: 8px 20px;
        font-size: 14px;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }

    .btn-view-profile:hover, .btn-slot-booking:hover {
        background-color: #e76a35;
    }

    .btn-slot-booking {
        background-color: #1d3268;
    }

    .btn-slot-booking:hover {
        background-color: #1d3268;
    }


    .slot-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .slot-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
    }

    .slot-list-item:hover {
        background-color: #e9ecef;
    }

    .slot-time {
        font-size: 16px;
        color: #1d3268;
        cursor: pointer;
        flex-grow: 1;
        text-align: left;
    }

    .btn-slot-booking {
        background-color: #1d3268;
        color: #fff !important;
        border-radius: 5px;
        padding: 8px 15px;
        font-size: 14px;
        cursor: pointer;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-slot-booking:hover {
        background-color: #e76a35;
    }

    .btn-booked {
        background-color: #e76a35;
        cursor: not-allowed;
    }

    .slot-time.selected {
        background-color: #e76a35;
        color: white;
    }

    .slot-time:active {
        background-color: #e76a35;
        color: white;
    }

    .text-center {
        text-align: center;
        color: #1d3268;
    }

</style>

<div class="container mt-5">
    <h2 class="text-center mb-4">Registered Members</h2>
    <div class="card-container">
        @foreach ($visitorsUsers as $visitorsUsersData)
            <div class="card">
                @php
                $photoPath = null;

                if (!empty($visitorsUsersData->members->id) && file_exists(public_path('ProfilePhoto/' . $visitorsUsersData->members->profilePhoto))) {
                    $photoPath = asset('ProfilePhoto/' . $visitorsUsersData->members->profilePhoto);
                } elseif (!empty($visitorsUsersData->visitors->id) && file_exists(public_path('VisitorPhoto/' . $visitorsUsersData->visitorPhoto))) {
                    $photoPath = asset('VisitorPhoto/' . $visitorsUsersData->visitorPhoto);
                }

                $firstName = $visitorsUsersData->members->firstName ?? $visitorsUsersData->visitors->firstName ?? '';
                $lastName = $visitorsUsersData->members->lastName ?? $visitorsUsersData->visitors->lastName ?? '';
                $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                @endphp

                <div class="profile-image">
                    @if ($photoPath)
                        <img src="{{ $photoPath }}" alt="Profile Picture">
                    @else
                        <span>{{ $initials }}</span>
                    @endif
                </div>

                <h5 class="card-title">

                    {{ $visitorsUsersData->members->firstName ?? '' }}
                    {{ $visitorsUsersData->members->lastName ?? ($visitorsUsersData->visitors->firstName ?? '') }}
                    {{ $visitorsUsersData->visitors->lastName ?? '' }}
                </h5>

                <div class="btn-container">
                    @if (isset($visitorsUsersData->members->id))
                        <a href="{{ route('viewMember.profile', $visitorsUsersData->members->id) }}" class="btn-view-profile">View Profile</a>
                    @else
                        <a href="{{ route('viewMember.profileUser', $visitorsUsersData->visitors->id) }}" class="btn-view-profile">View Profile</a>
                    @endif


                    @if(isset($event) && $event->slot_date)
                        <button class="btn-slot-booking" data-bs-toggle="modal" data-bs-target="#slotModal">
                            Slot Booking
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="slotModal" tabindex="-1" aria-labelledby="slotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="slotModalLabel">Available Slots</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="slot-list">
                        @foreach ($slots as $slotData)
                            <li class="slot-list-item">
                                <span>{{ $slotData->start_time }} - {{ $slotData->end_time }}</span>
                                <form action="{{ route('slotbooking.visitor', $slotData->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="visitorId" value="{{ session('visitor_id') }}">
                                    <input type="hidden" name="eventId" value="{{ $event->id }}">
                                    <input type="hidden" name="slotId" value="{{ $slotData->id }}">
                                    <input type="hidden" name="regMemberId" value="{{ $visitorsUsersData->id }}">
                                    <button type="submit" class="btn-slot-booking">
                                        @if (\App\Models\SlotBooking::where('eventId', $event->id)->where('slotId', $slotData->id)->exists())
                                            Booked
                                        @else
                                            Book Slot
                                        @endif
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
