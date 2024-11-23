@extends('layouts.masterVisitor')

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
        margin-bottom: 10px;
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
</style>
    <div class="container mt-5">
        <h2 class="text-center mb-4 card-title">Registered Members</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($visitorsUsers as $visitorsUsersData)
                <div>
                    <div class="profile-card">
                        @if (file_exists(public_path('VisitorPhoto/' . $visitorsUsersData->visitorPhoto)))
                            <img src="{{ asset('VisitorPhoto/' . $visitorsUsersData->visitorPhoto) }}" alt="Profile Picture">
                        @else
                            <div class="profile-placeholder"></div>
                        @endif
                        <div class="name" style="color: #e76a35">{{ $visitorsUsersData->members->firstName ?? '' }} {{ $visitorsUsersData->members->lastName ?? ($visitorsUsersData->visitors->firstName ?? '')  }} {{ $visitorsUsersData->visitors->lastName ?? '' }}</div>
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
                                    <form action="{{ route('slotbooking.visitor', $slotData->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="visitorId" value="{{ session('visitor_id') }}">
                                        <input type="hidden" name="eventId" value="{{ $event->id }}">
                                        <input type="hidden" name="slotId" value="{{ $slotData->id }}">
                                        <input type="hidden" name="regMemberId" value="{{ $visitorsUsersData->id }}">
                                        <button type="submit" class="book-slot-btn">

                                            @php
                                            $visitor = session('visitor_id');
                                            $slotBooking = \App\Models\SlotBooking::where('eventId', $event->id)->where('slotId', $slotData->id)->first();
                                            @endphp


                                            @if ($slotBooking)
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

