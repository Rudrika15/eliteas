@extends('layouts.master')

@section('header', 'View Members')
@section('content')


<style>
    .profile-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .profile-card img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        /* margin-bottom: 10px; */
    }

    .profile-card .name {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .profile-card .designation {
        font-size: 0.9rem;
        color: #555;
    }

    .modal-header {
        background-color: #e76a35;
        color: white;
    }

    .modal-body {
        padding: 20px;
    }

    .slot-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .slot-list-item {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .slot-list-item:hover {
        background-color: #f8f9fa;
    }

    .book-slot-btn {
        background-color: #1d3268;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .book-slot-btn:hover {
        background-color: #0056b3;
    }

    .profile-placeholder {
    width: 80px;
    height: 80px;
    background-color: #ccc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: bold;
    color: #1d3268;
    text-align: center; /* Ensures text is centered */
    line-height: normal; /* Prevents text alignment issues */
    margin-left: 100px;
}
</style>


<div class="container mt-5">
        <h2 class="text-center mb-4 card-title">Registered Members</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($visitorsUsers as $visitorsUsersData)
            <div>
                <div class="profile-card">
                    @php
                    $photoPath = null;

                    // Check for the image in the respective folders
                    if (!empty($visitorsUsersData->members->id) && file_exists(public_path('ProfilePhoto/' . $visitorsUsersData->members->profilePhoto))) {
                        $photoPath = asset('ProfilePhoto/' . $visitorsUsersData->members->profilePhoto);
                    } elseif (!empty($visitorsUsersData->visitors->id) && file_exists(public_path('VisitorPhoto/' . $visitorsUsersData->visitorPhoto))) {
                        $photoPath = asset('VisitorPhoto/' . $visitorsUsersData->visitorPhoto);
                    }

                    // Fallback to initials if no photo is available
                    $firstName = $visitorsUsersData->members->firstName ?? $visitorsUsersData->visitors->firstName ?? '';
                    $lastName = $visitorsUsersData->members->lastName ?? $visitorsUsersData->visitors->lastName ?? '';
                    $initials = strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1));
                @endphp

                @if ($photoPath)
                    <img src="{{ $photoPath }}" alt="Profile Picture">
                @else
                    <div class="profile-placeholder">
                        <span>{{ $initials }}</span>
                    </div>
                @endif

                {{-- <div class="name" style="color: #e76a35">
                    {{ $firstName }} {{ $lastName }}
                </div> --}}
                    <div class="name mt-3" style="color: #e76a35">{{ $visitorsUsersData->members->firstName ?? '' }} {{ $visitorsUsersData->members->lastName ?? ($visitorsUsersData->visitors->firstName ?? '')  }} {{ $visitorsUsersData->visitors->lastName ?? '' }}</div>
                    <a href="#" class="btn btn-bg-blue btn-sm mt-3">View Profile</a>
                    @if(isset($event) && $event->slot_date)
                        <button class="btn btn-bg-orange btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#slotModal">
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
                                    <form action="{{ route('slotbooking.member', $slotData->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="eventId" value="{{ $event->id }}">
                                        <input type="hidden" name="slotId" value="{{ $slotData->id }}">
                                        <input type="hidden" name="regMemberId" value="{{ $visitorsUsersData->id }}">
                                        <button type="submit" class="book-slot-btn">

                                            @php
                                            $slotBooking = \App\Models\SlotBooking::where('eventId', $event->id)->where('slotId', $slotData->id)->first();
                                            @endphp

                                            @if ($slotBooking)
                                            Booked
                                            @else
                                            Book Slot
                                            @endif
                                        </button>
                                    </form>
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

