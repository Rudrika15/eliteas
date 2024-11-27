@extends('layouts.masterVisitor')

@section('title', 'UBN - Visitor Dashboard')
@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <p class="mt-3 text-muted text-center"><b> Welcome to UBN Visitor Dashboard. </b></p>
            </div>
        </div>
    </div>

    {{-- <p>Visitor ID: {{ session('visitor_id') }}</p>
<p>Visitor Name: {{ session('visitor_name') }}</p>
<p>Visitor Email: {{ session('visitor_email') }}</p> --}}


    <div class="row">
        <div class="col-md-12">
            <div class="card-title"><b>Upcoming Events</b></div>
            <div class="card border-0 shadow workshopCard">
                {{-- {{$nearestTraining}} --}}
                @if ($nearestEvents)
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <h4 class="card-title">{{ $nearestEvents->title }}</h4>
                                <p class="card-text text-muted"> <b> Total Registered Members : {{ $totalRegisterCount }} </b></p>
                            </div>

                            <div class="col-md-2 pt-3 text-muted text-end">
                                <b>Date : </b> {{ \Carbon\Carbon::parse($nearestEvents->event_date)->format('j M Y') }}
                                <br>
                                <b>Start Time :</b> {{ $nearestEvents->start_time }} <br>
                                <b>End Time :</b> {{ $nearestEvents->end_time }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {{-- @if (!is_null($findEventRegister) && count($findEventRegister) == 0) --}}
                                    @if ($nearestEvents->amount == 0)
                                        <h5 class="text-muted text-end me-4 pt-5">Free</h5>
                                        <form method="POST" action="{{ route('visitor.register.dash', ['eventId' => $nearestEvents->id]) }}">
                                            @csrf

                                            @php
                                            $visitor = session('visitor_id');
                                            $eventRegister = \App\Models\VisitorEventRegister::where('visitorId', $visitor)->where('eventId', $nearestEvents->id)->first();
                                            @endphp

                                            <div class="d-flex justify-content-end">

                                                @if ($eventRegister)
                                                <div class="ps-5 ms-5 mt-5">
                                                    <strong><span class="text-success">Already Joined</span></strong>
                                                </div>
                                                @else
                                                <button type="submit" class="btn btn-bg-orange btn-md " id="freeRegisterBtn">
                                                    Register
                                                </button>
                                                @endif
                                            </div>
                                        </form>
                                        @endif
                                    {{-- @else
                                        <h5 class="text-muted text-end me-4 pt-3"> ₹ {{ $nearestEvents->fees }}</h5>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-bg-orange btn-md" id="razorpayBtnEvent" data-amount-event="{{ $nearestEvents->fees }}">
                                                Join Now
                                            </button>
                                        </div>
                                    @endif --}}
                                {{-- @else
                                    <div class="d-flex justify-content-end">
                                        <div class="ps-5 ms-5 mt-5">
                                            <strong><span class="text-success">Already Joined</span></strong> --}}
                                        {{-- </div> --}}

                                        @php
                                        $visitor = session('visitor_id');
                                        $eventRegister = \App\Models\VisitorEventRegister::where('visitorId', $visitor)->where('eventId', $nearestEvents->id)->first();
                                        @endphp





                                    @if ($nearestEvents->slot_date && $eventRegister)
                                        @php
                                            $isSlotBooked = \App\Models\SlotBooking::where('eventId', $nearestEvents->id)
                                                ->where('visitorId', session('visitor_id'))
                                                ->exists();
                                        @endphp
                                        <div class="ps-5 ms-5 mt-5 d-flex justify-content-end">
                                            @if ($isSlotBooked)
                                                <button type="button" class="btn btn-bg-orange btn-md" id="viewMembers"
                                                onclick="location.href='{{ route('event.viewMembersForVisitors', ['id' => $nearestEvents->id]) }}'">
                                                View Members
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-bg-orange btn-md" id="slotBooking"
                                                onclick="location.href='{{ route('event.viewMembersForVisitors', ['id' => $nearestEvents->id]) }}'">
                                                Slot Booking
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                            </div>
                        </div>

                        <!-- Shareable Link Section -->
                        {{-- <div class="row mt-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('event.link', $nearestEvents->event_slug) }}" target="_blank">
                                View Event Details
                            </a>
                        </div>
                        <div>
                            <button class="btn btn-bg-blue btn-sm" onclick="copyLink()">
                                Copy Shareable Link
                            </button>
                            <input type="hidden" id="shareableLink"
                                value="{{ route('event.link', $nearestEvents->event_slug) }}">
                        </div>
                    </div>
                </div>
            </div> --}}

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{-- <a href="{{ route('event.link', $nearestEvents->event_slug) }}" target="_blank">
                                View Event Details
                            </a> --}}
                                    </div>
                                    {{-- <div>
                                        <button class="btn btn-bg-blue btn-sm" onclick="copyLink()">
                                            Invite Via Link
                                        </button>
                                        <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $nearestEvents->event_slug, 'ref' => auth()->user()->member->id]) }}">
                                    </div> --}}

                                    <style>
                                        #shareableLink {
                                            display: none;
                                        }
                                    </style>

                                </div>
                            </div>
                        </div>



                    </div>
                @else
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mt-3 text-muted text-center"><b>No Events for now.</b></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>



@endsection
