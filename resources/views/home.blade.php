@extends('layouts.master')

@section('title', 'UBN - Dashboard')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    <div class="container">
        <style>
            .workshopCard {
                position: relative;
            }

            .workshopCard::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border-top: 2px solid transparent;
                border-bottom: 2px solid transparent;
                border-left: 2px solid #007bff;
                /* Left border */
                border-right: 2px solid #007bff;
                /* Right border */
                z-index: 1;
                transition: box-shadow 0.3s ease-in-out;
                /* Add transition for smooth effect */
            }

            .workshopCard:hover::before {
                box-shadow: 0 0 20px rgba(88, 168, 253, 0.4);
                /* Shadow effect on hover */
            }

            .workshopCard .card-body {
                position: relative;
                z-index: 2;
            }

            .p-testimonial-message {
                width: 70%;
                /* this code clamps based on specified lines */
                overflow: hidden;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
                display: -webkit-box;
            }
        </style>


        {{--
    @role('Member')

    @if (isset($error))
    <div class="alert alert-danger">{{ $error }}</div>
    @endif

    @if (isset($listOfUser) && $listOfUser->count())
    <ul>
        @foreach ($listOfUser as $user)
        <li>{{ $user->firstName }} {{ $user->lastName }}</li>
        @endforeach
    </ul>
    @else
    <p>No users found.</p>
    @endif


    @endrole --}}



        @role('Member')


            <div class="row">
                @if (count($birthdaysToday) > 0)
                    <div class="col-md-12">
                        <style>
                            .birthday-card {
                                width: 350px;
                                height: 400px;
                                position: relative;
                                border: 12px solid #fff;
                                box-shadow: 10px 10px 8px 4px rgba(10, 10, 10, 0.3);
                                border-radius: 10px;
                                overflow: hidden;
                                text-align: center;
                            }

                            .birthday-image {
                                width: 400px;
                                height: 400px;
                                object-fit: cover;
                                /* Ensures the image fully covers the container */
                                position: absolute;
                                top: 0;
                                left: 0;
                                z-index: 1;
                            }

                            .birthday-overlay {
                                width: 100%;
                                height: 100%;
                                position: absolute;
                                top: 0;
                                left: 0;
                                z-index: 2;
                                /* Ensures the overlay is above the image */
                                object-fit: cover;
                                /* Makes the overlay scale properly */
                            }

                            .birthday-text {
                                position: absolute;
                                bottom: 10px;
                                left: 0;
                                right: 0;
                                margin: 0 auto;
                                color: white;
                                font-size: 18px;
                                font-weight: bold;
                                text-align: center;
                                background-color: rgba(0, 0, 0, 0.6);
                                /* Semi-transparent background for text */
                                padding: 10px;
                                z-index: 3;
                                /* Ensures the text is above the overlay */
                                border-radius: 5px;
                            }
                        </style>
                        <div class="row">
                            @foreach ($birthdaysToday as $birthday)
                                <div class="col-md-4">
                                    <div class="card shadow w-100">
                                        <div class="card-header">
                                            <b style="color: #1d2856;">Birthday reminders</b>
                                            <i class="bi bi-balloon" style="color: rgb(255, 187, 0);"></i>
                                        </div>
                                        <div class="card-body">
                                            <div class="birthday-card">
                                                <img class="birthday-image" src="{{ asset('ProfilePhoto') }}/{{ $birthday->profilePhoto }}" alt="Birthday Image">
                                                <img class="birthday-overlay" src="{{ asset('templateImage') }}/{{ $templates->templateImage }}" alt="Template Overlay">
                                                <div class="birthday-text">
                                                    <p>{{ $birthday->firstName }}'s Birthday</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>



            <div>
                @if ((isset($circlecalls) && count($circlecalls) > 0) || (isset($busGiver) && count($busGiver) > 0) || (isset($refGiver) && count($refGiver) > 0))
                    <div class="card-header">
                        <b style="color: #1d2856; font-size:15px">Leader Board -
                            {{ \Carbon\Carbon::now()->subMonth()->format('F Y') }}</b>
                    </div>
                    <div class="row  row-cols-1 row-cols-md-3 g-4 mt-2">

                        @if ($circlecalls)
                            <div class="col ">
                                <div class="card ">

                                    @php
                                        $profilePhoto = $circlecalls['member']->profilePhoto ?? 'profile.png';
                                    @endphp

                                    <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" class="mt-3" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: contain; aspect-ratio: 1/1;">

                                    <div class="card-body">
                                        <h5 class="card-title text-center">Max Business Meets</h5>
                                        <p class="card-text text-center">
                                            <span style="font-size: 18px; color: #e76a35; font-weight: bold;">
                                                {{ $circlecalls['member']->firstName }}
                                                {{ $circlecalls['member']->lastName }}<br>
                                            </span>
                                            <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                        <div style="display: flex; justify-content: center;">
                                            <span style="font-size: 14px; text-align: center;">
                                                <span style="color: #e76a35; font-weight: bold;">Circle:
                                                    {{ $circlecalls['member']->circle->circleName }}</span><br>
                                            </span>
                                        </div>
                                        <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                        <div style="display: flex; justify-content: center;">
                                            <span style="font-size: 12px; text-align: center;">
                                                <span style="color: #e76a35; font-weight: bold;">Meetings Count:
                                                    {{ $circlecalls['count'] }}</span><br>
                                            </span>
                                        </div>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        @endif

                        @if ($busGiver)
                            <div class="col">
                                <div class="card">
                                    @php
                                        $profilePhoto = $busGiver['member']->profilePhoto ?? 'profile.png';
                                    @endphp

                                    <img src="{{ asset('ProfilePhoto/' . $profilePhoto) }}" class="mt-3" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: contain; aspect-ratio: 1/1;">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Max Business Leader</h5>
                                        <p class="card-text text-center">
                                            <span style="font-size: 18px; color: #e76a35; font-weight: bold;">
                                                {{ $busGiver['user']->firstName }} {{ $busGiver['user']->lastName }}<br>
                                            </span>
                                            <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                        <div style="display: flex; justify-content: center;">
                                            <span style="font-size: 14px; text-align: center;">
                                                <span style="color: #e76a35; font-weight: bold;">Circle:
                                                    {{ $busGiver['circle']['circleName'] }}</span><br>
                                            </span>
                                        </div>
                                        <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                        <div style="display: flex; justify-content: center;">
                                            <span style="font-size: 12px; text-align: center;">
                                                <span style="color: #e76a35; font-weight: bold;">Meetings Count:
                                                    {{ $busGiver['count'] }}</span><br>
                                                <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                                <span style="color: #e76a35; font-weight: bold;">Amount:
                                                    {{ $busGiver['amount'] }}</span><br>
                                            </span>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($refGiver)
                            <div class="col">
                                <div class="card">
                                    <img src="{{ asset('ProfilePhoto/' . ($refGiver['profilePhoto'] ?? 'profile.png')) }}" class="mt-3" alt="Profile Photo" style="width: 100%; height: 100%; object-fit: contain; aspect-ratio: 1/1;">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Top Reference Giver</h5>
                                        <p class="card-text text-center">
                                            <span style="font-size: 18px; color: #e76a35; font-weight: bold;">
                                                {{ $refGiver['user']->firstName ?? 'N/A' }}
                                                {{ $refGiver['user']->lastName ?? 'N/A' }}<br>
                                            </span>
                                            <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                        <div style="display: flex; justify-content: center;">
                                            <span style="font-size: 14px; text-align: center;">
                                                <span style="color: #e76a35; font-weight: bold;">Circle:
                                                    {{ $refGiver['circle'] ?? 'N/A' }}</span><br>
                                            </span>
                                        </div>
                                        <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                        <div style="display: flex; justify-content: center;">
                                            <span style="font-size: 12px; text-align: center;">
                                                <span style="color: #e76a35; font-weight: bold;">References Count:
                                                    {{ $refGiver['count'] ?? '0' }}</span><br>

                                                <hr class="mx-auto" style="color: #e76a35; width: 30%;">
                                                <span style="color: #e76a35; font-weight: bold;">Business Category:
                                                    {{ $refGiver['businessCategory'] ?? 'N/A' }}</span><br>
                                            </span>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                @endif
            </div>
        </div>


        @if ($meeting == null)
            <div class="container-responsive">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-title"><b>Upcoming Circle Meetings</b></div>
                        <div class="card border-0 shadow workshopCard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info" role="alert">
                                            No upcoming circle meeting found
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container-responsive">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-title"><b>Upcoming Circle Meetings</b></div>
                        <div class="card border-0 shadow workshopCard">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="card-title">{{ $meeting->circle->circleName }}
                                            <span class="text-muted">( {{ $meeting->circle->city->cityName }}
                                                )</span>
                                        </h4>
                                    </div>
                                    <div class="col-md-6 pt-3 text-muted text-end">
                                        {{ $meeting->date->format('j M Y') }} <br>
                                        {{ $meeting->meetingTime }}
                                    </div>
                                </div>
                                <p>
                                    <small class="fw-italic text-muted pt-2 fw-italic">
                                        Total Members : {{ $meeting->circle->members->count() }}
                                    </small>
                                    <br>
                                    <small class="text-muted">
                                        Franchise Name : {{ $meeting->circle->franchise->franchiseName }}
                                    </small>
                                </p>
                                <div class="row">
                                    <div class="col-md-11 ps-3 card-title ">Invite people to join</div>
                                    <div class="col-md-1 mt-2">
                                        {{-- <button type="button" class="btn btn-bg-orange btn-sm mt-2"
                                            onclick="openInvitePage('{{ $meeting->cm_slug }}', '{{ $meeting->id }}', '{{ auth()->user()->member->id }}')"
                                            target="_blank">
                                            Invite
                                        </button> --}}

                                        <button type="button" class="btn btn-bg-orange btn-sm mt-2" onclick="openInvitePage('{{ $signedUrl }}')">
                                            Invite
                                        </button>

                                        <script>
                                            function openInvitePage(url) {
                                                // Open the pre-generated signed URL in a new tab
                                                window.open(url, '_blank');
                                            }
                                        </script>



                                    </div>
                                </div>

                                {{-- <script>
                                    function openInvitePage(slug, meetingId, memberId) {
                                        // Construct the URL for the visitor form page
                                        const url = `/visitor-form?slug=${slug}&meetingId=${meetingId}&ref=${memberId}`;
                                        // Open the URL in a new tab
                                        window.open(url, '_blank'); // This will open the URL in a new tab
                                    }
                                </script> --}}


                                {{-- <div class="row">
                                    <div class="col-md-11 ps-3 card-title "></div>
                                    <div class="col-md-1 mt-2">
                                        <button type="button" class="btn btn-bg-orange btn-sm mt-2"
                                            onclick="openInvitePage('{{ $meeting->cm_slug }}', '{{ auth()->user()->memberId }}')"
                                            target="_blank">
                                            Invite Via Link
                                        </button>
                                    </div>
                                </div> --}}

                                <div class="justify-content-end">
                                    <button class="btn btn-bg-blue btn-sm" onclick="copyMeetingLink()">
                                        Invite Via Link
                                    </button>
                                    <input type="hidden" id="shareableMeetingLink" value="{{ URL::signedRoute('visitor.form', ['slug' => $meeting->cm_slug, 'meetingId' => $meeting->id, 'ref' => auth()->user()->member->id]) }}">
                                </div>

                                <script>
                                    function copyMeetingLink() {
                                        var copyText = document.getElementById("shareableMeetingLink").value;
                                        navigator.clipboard.writeText(copyText).then(function() {
                                            alert("Link copied to clipboard");
                                        }, function(err) {
                                            alert("Could not copy link");
                                        });
                                    }
                                </script>

                                <div class="accordion mt-3">
                                    <div class="accordion-item ">
                                        <div class="accordion-header" id="headingSix">

                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                <div class="card-title"> My Invites </div>
                                            </button>
                                        </div>

                                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table table-border datatable table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>Contact</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($myInvites->count() == 0)
                                                                <tr>
                                                                    <td colspan="2" class="text-muted text-center">
                                                                        No
                                                                        Invites
                                                                        for
                                                                        current
                                                                        meeting</td>
                                                                </tr>
                                                            @else
                                                                @foreach ($myInvites as $invite)
                                                                    <tr>
                                                                        <td><small class="text-muted">{{ $invite->personName }}</small>
                                                                        </td>
                                                                        <td><small class="text-muted">{{ $invite->personEmail }}</small>
                                                                        <td><small class="text-muted">{{ $invite->personContact }}</small>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card-title"><b>Upcoming Training Workshops</b></div>
                <div class="card border-0 shadow workshopCard">
                    {{-- {{$nearestTraining}} --}}
                    @if ($nearestTraining)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <h4 class="card-title">{{ $nearestTraining->title }}</h4>
                                    @if ($nearestTraining->venue)
                                        <b>Venue:</b> {{ $nearestTraining->venue }}
                                    @endif
                                </div>

                                <div class="col-md-2 pt-3 text-muted text-end">
                                    <b>Date : </b> {{ \Carbon\Carbon::parse($nearestTraining->date)->format('j M Y') }}
                                    <br>
                                    <b>Time :</b> {{ $nearestTraining->time }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mt-4">
                                    <p class="text-muted"><strong>Trainer Details:</strong><br>
                                        <small class="fw-italic text-muted pt-2 fw-italic">

                                            @foreach ($nearestTraining->trainers as $user)
                                                <input type="hidden" value="{{ $user->user->id }}" name="trainerId" class="trainerId">
                                                <input type="hidden" value="{{ $nearestTraining->id }}" name="trainingId" class="trainingId">
                                                {{ $user->user->firstName }}
                                                {{ $user->user->lastName }}
                                                <br>
                                            @endforeach


                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            {{ $nearestTraining->trainersTrainings->externalMemberBio ?? '' }}
                                        </small>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    @if (count($findRegister) == 0)
                                        @if ($nearestTraining->fees == 0)
                                            <h5 class="text-muted text-end me-4 pt-5">Free</h5>
                                            <button type="button" class="btn btn-bg-orange btn-md" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                Register
                                            </button>
                                        @else
                                            <h5 class="text-muted text-end me-4 pt-3"> ₹
                                                {{ $nearestTraining->fees }}
                                            </h5>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-bg-orange btn-md " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Join Now
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        <div class="d-flex justify-content-end">
                                            <div class="ps-5 ms-5 mt-5">
                                                <strong> <span class="text-success">Already Joined</span> </strong>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <p class="mt-3 text-muted text-center"> <b> No Training Workshop for now. </b></p>
            </div>
        </div>
        </div>
        </div>
        </div>
        @endif



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
                                    <p class="card-text text-muted"> <b> Total Registered Members : {{ $nearestEvents->registrations->count() }} </b></p>
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
                                    @if (!is_null($findEventRegister) && count($findEventRegister) == 0)
                                        @if ($nearestEvents->amount == 0)
                                            <h5 class="text-muted text-end me-4 pt-5">Free</h5>
                                            <form method="POST" action="{{ route('event.register', ['eventId' => $nearestEvents->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-bg-orange btn-md" id="freeRegisterBtn">
                                                    Register
                                                </button>
                                            </form>
                                        @else
                                            <h5 class="text-muted text-end me-4 pt-3"> ₹ {{ $nearestEvents->amount }}</h5>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-bg-orange btn-md" id="razorpayBtnEvent" data-amount-event="{{ $nearestEvents->amount }}">
                                                    Join Now
                                                </button>
                                            </div>
                                        @endif
                                    @else
                                        <div class="d-flex justify-content-end">
                                            <div class="ps-5 ms-5 mt-5">
                                                <strong><span class="text-success">Already Joined</span></strong>
                                            </div>
                                        @if ($nearestEvents->slot_date)
                                        <div class="ps-5 ms-5 mt-5">
                                            <button type="button" class="btn btn-bg-orange btn-md" id="slotBooking"
                                            onclick="location.href='{{ route('event.viewMembers', ['id' => $nearestEvents->id]) }}'">
                                        Slot Booking
                                    </button>

                                        </div>
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
                                        <div>
                                            <button class="btn btn-bg-blue btn-sm" onclick="copyLink()">
                                                Invite Via Link
                                            </button>
                                            <input type="hidden" id="shareableLink" value="{{ URL::signedRoute('event.link', ['slug' => $nearestEvents->event_slug, 'ref' => auth()->user()->member->id]) }}">
                                        </div>

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


        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <script>
            function copyLink() {
                var copyText = document.getElementById("shareableLink").value;
                navigator.clipboard.writeText(copyText).then(function() {
                    alert("Link copied to clipboard");
                }, function(err) {
                    alert("Could not copy link");
                });
            }
        </script>
        <script>
            function copyLink() {
                var copyText = document.getElementById("shareableLink").value;
                navigator.clipboard.writeText(copyText).then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Link copied!',
                        text: 'The link has been copied to your clipboard.',
                        confirmButtonText: 'OK'
                    });
                }, function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Could not copy the link. Please try again.',
                        confirmButtonText: 'OK'
                    });
                });
            }
        </script>
        <script>
            function copyMeetingLink() {
                var copyText = document.getElementById("shareableMeetingLink").value;
                navigator.clipboard.writeText(copyText).then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Link copied!',
                        text: 'The link has been copied to your clipboard.',
                        confirmButtonText: 'OK'
                    });
                }, function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Could not copy the link. Please try again.',
                        confirmButtonText: 'OK'
                    });
                });
            }
        </script>




        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        @if ($nearestEvents)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Get the Razorpay button
                    var razorpayBtnEvent = document.getElementById('razorpayBtnEvent');
                    console.log('Razorpay button:', razorpayBtnEvent);

                    // Check if the button exists before attaching event
                    if (razorpayBtnEvent) {
                        razorpayBtnEvent.addEventListener('click', function() {
                            // Get event amount from data-amount attribute
                            var amount = parseInt(razorpayBtnEvent.getAttribute('data-amount-event')) *
                                100; // convert to paise
                            console.log('Event Amount (in paise):', amount);

                            // Razorpay key from environment variable
                            var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                            console.log('Razorpay Key:', razorpayKey);

                            if (!razorpayKey) {
                                console.error('Razorpay key is missing.');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Payment configuration error. Please contact support.',
                                });
                                return;
                            }

                            // Prefill user details
                            var username = "{{ Auth::user()->name }}";
                            var useremail = "{{ Auth::user()->email }}";
                            console.log('User Name:', username);
                            console.log('User Email:', useremail);

                            // Razorpay options
                            var eventOptions = {
                                "key": razorpayKey,
                                "amount": amount,
                                "currency": "INR",
                                "name": "{{ $nearestEvents->title }}", // Event title
                                "description": "Event Registration Payment",
                                "image": "/img/logo.png", // Your company logo
                                "handler": function(response) {
                                    console.log('Payment successful, Payment ID:', response
                                        .razorpay_payment_id);
                                    storeEventPaymentDetails(response.razorpay_payment_id, amount);
                                },
                                "prefill": {
                                    "name": username,
                                    "email": useremail
                                },
                                "theme": {
                                    "color": "#F37254"
                                }
                            };

                            // Open Razorpay checkout
                            var rzp = new Razorpay(eventOptions);
                            rzp.open();
                        });
                    }
                });

                // Function to store payment details after successful payment
                function storeEventPaymentDetails(paymentId, amount) {
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var url = `{{ route('razorpay.payment.eventPayment') }}`;
                    var eventId = '{{ $nearestEvents->id }}';

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                paymentId: paymentId,
                                amount: amount,
                                eventId: eventId
                            })
                        })
                        .then(response => {
                            console.log('Payment details stored successfully.');
                            Swal.fire({
                                icon: 'success',
                                title: 'Payment Successful',
                                text: 'You have successfully registered for the event.',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload(); // Reload page to reflect registration status
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error storing payment details:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to store payment details.',
                            });
                        });
                }
            </script>
        @endif







        <div class="row">
            <div class="col-md-12">
                <div class="card-title"><b>Monthly Meeting Payment</b></div>
                <div class="card border-0 shadow workshopCard">
                    @if ($monthlyPayments->isNotEmpty())
                        <div class="card-body">
                            @foreach ($monthlyPayments as $month => $payments)
                                @php
                                    $currentMonth = now()->format('F - Y');
                                    $isCurrentMonth = $month == $currentMonth;
                                    $isUnpaid = $payments->first()->status == 'unpaid';
                                @endphp

                                @if ($isUnpaid)
                                    <div class="alert alert-warning mt-3">
                                        <strong>Payment Pending!</strong> Your payment is pending for
                                        <b>{{ $month }}</b>.
                                    </div>
                                    <ul>
                                        @foreach ($payments as $payment)
                                            <li class="mt-3">
                                                <b>{{ $month }}:</b> <span class="text-danger">Pending</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="alert alert-success">
                                        <strong>Payment Completed!</strong> Your payment for <b>{{ $month }}</b> has
                                        already been made.
                                    </div>
                                @endif
                            @endforeach

                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-bg-orange btn-md monthlyPay" data-amount="{{ $totalAmountDue }}">
                                    Pay ₹{{ $totalAmountDue }}
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <p class="mt-5 text-muted text-center"><b>No Monthly Payment data available.</b></p>
                        </div>
                    @endif
                </div>
            </div>
        </div>




        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        @if ($monthlyPayments)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Get all elements with the 'monthlyPay' class
                    var monthlyPayButton = document.querySelectorAll('.monthlyPay');
                    console.log('pay buttons', monthlyPayButton);

                    // Loop through each pay button and attach the click event handler
                    monthlyPayButton.forEach(function(button) {
                        button.addEventListener('click', function(e) {

                            // Retrieve the amount from the data attribute
                            var amount = parseInt(button.getAttribute('data-amount')) *
                                100; // Convert to paise

                            console.log('amount:', amount);

                            var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                            console.log('Razorpay Key:', razorpayKey);

                            // Ensure that the Razorpay key is available
                            if (!razorpayKey) {
                                console.error('Razorpay key is missing.');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Payment configuration error. Please contact support.',
                                });
                                return;
                            }

                            var username = "{{ Auth::user()->name }}";
                            var useremail = "{{ Auth::user()->email }}";
                            console.log('username:', username);
                            console.log('useremail:', useremail);

                            var payOptions = {
                                "key": razorpayKey,
                                "amount": amount,
                                "currency": "INR",
                                "name": "UBN",
                                "description": "Monthly payment",
                                "image": "/img/logo.png",
                                "handler": function(response) {
                                    // Handle the response after payment
                                    console.log('Payment response:', response);
                                    var paymentId = response.razorpay_payment_id;
                                    storeMonthlyPaymentId(paymentId, amount);
                                },
                                "prefill": {
                                    "name": username,
                                    "email": useremail
                                },
                                "theme": {
                                    "color": "#012e6f"
                                }
                            };

                            var rzp = new Razorpay(payOptions);
                            rzp.open();
                            console.log('razorpayKey is working');

                        });
                    });
                });

                function storeMonthlyPaymentId(paymentId = '', amount = '') {
                    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    var url = `{{ route('razorpay.payment.monthlyPaymentStore') }}`;



                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({
                                paymentId: paymentId,
                                amount: amount,

                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Payment ID stored successfully:', data);
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Payment Successful',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error storing payment ID:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to store payment ID',
                            });
                        });
                }
            </script>
        @endif
    @endrole




    @role('Admin')

        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('schedule.dashIndex') }}" class="card-link">
                    <div class="card shadow">
                        <div class="card-header">
                            <b style="color: #1d2856;">Upcoming Circle Meetings</b>
                            <i class="bi bi-calendar3" style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            {{-- <h2>{{ $count }}</h2> --}}
                        </div>
                    </div>
                </a>
            </div>

            {{-- <div class="col-md-4">
        <a href="{{ route('pendingPayments.index') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Pending Payments</b>
                    <i class="bi bi-credit-card"
                        style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>{{ $count }}</h2>
                </div>
            </div>
        </a>
    </div> --}}

            {{-- <div class="col-md-4">
        <a href="{{ route('maxMeetings.index') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Meetings Leaderboard</b>
                    <i class="bi bi-bookmark-star"
                        style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                </div>
            </div>
        </a>
    </div> --}}

            {{-- <div class="col-md-4">
        <a href="{{ route('maxBusiness.index') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Business Leaderboard</b>
                    <i class="bi bi-bookmark-star"
                        style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>{{ $count }}</h2>
                </div>
            </div>
        </a>
    </div> --}}

            {{-- <div class="col-md-4">
        <a href="{{ route('maxReference.index') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Reference Leaderboard</b>
                    <i class="bi bi-bookmark-star"
                        style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>{{ $count }}</h2>
                </div>
            </div>
        </a>
    </div> --}}

            {{-- <div class="col-md-4">
        <a href="{{ route('maxRefferal.index') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Referral Leaderboard</b>
                    <i class="bi bi-bookmark-star"
                        style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>{{ $count }}</h2>
                </div>
            </div>
        </a>
    </div> --}}

            {{-- <div class="col-md-4">
        <a href="{{ route('maxVisitor.index') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Visitors</b>
                    <i class="bi bi-people" style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <h2>{{ $count }}</h2>
                </div>
            </div>
        </a>
    </div> --}}
        </div>
        </div>
    @endrole




    {{-- Invited People Admin Side Start --}}

    @role('Admin')
        {{-- <div class="col-md-3">
    <div class="col-md-12">
        <div class="card-title"><b>Invited People List</b></div>
    </div>
    <div class="card border-0 shadow workshopCard">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item text-center fw-bold">All Circle Meetings Invites</li>
                            @foreach ($myInvites->take(3) as $invite)
                            <li class="list-group-item">
                                {{ $invite->personName }}
                                <br>
                                <small class="text-muted">{{ $invite->personEmail }}</small>
                                <br>
                                Invited by - {{ $invite->user->firstName }} {{ $invite->user->lastName }}
                            </li>
                            @endforeach
                            <li class="list-group-item text-center fw-bold">
                                <a href="{{ route('invitedPersonList') }}" class="btn btn-bg-blue btn-sm mt-2">
                                    Show More...
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

        <!-- Bootstrap Modal -->
        <div class="modal fade" id="allInvitesModal" tabindex="-1" aria-labelledby="allInvitesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="allInvitesModalLabel">All Training Invites</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Training Name</th>
                                        <th>Invited By</th>
                                        <th>Person Name</th>
                                        <th>Person Email</th>
                                        <th>Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myInvites as $invite)
                                        <tr>
                                            <td>{{ $invite->training->title }}</td>
                                            <td>{{ $invite->user->firstName }} {{ $invite->user->lastName }}</td>
                                            <td>{{ $invite->personName }}</td>
                                            <td>{{ $invite->personEmail }}</td>
                                            @php
                                                $statusColors = [
                                                    'Pending' => 'red',
                                                    'Accepted' => 'green',
                                                    'Rejected' => 'red',
                                                ];
                                            @endphp
                                            <td style="background-color: {{ $statusColors[$invite->paymentStatus] ?? 'red' }}; color: white;">
                                                {{ Str::ucfirst($invite->paymentStatus) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-bg-blue" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endrole



    {{-- Invited People Admin Side End --}}




    {{-- Testimonial --}}
    @auth
        @if (!auth()->user()->hasRole('Admin'))
            @if (count($testimonials) > 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-title text-center text"><b>Testimonials</b></div>
                    </div>
                </div>
                <div class="row" style=" position: relative;">
                    <div class="col-md-9" style="position: relative; left: 50%; transform: translateX(-50%);">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel" style=" position: relative;">
                            <div class="carousel-inner">
                                @foreach ($testimonials as $key => $testimonial)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="position: relative;">
                                        <div class="card" style="border-radius:10px; height:250px; box-shadow: 0 4px 6px rgba(0,0,0,.1);">
                                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                                {{-- {{asset('/')}} --}}
                                                {{-- {{$testimonial->member->profilePhoto}} --}}
                                                <img src="{{ asset('ProfilePhoto/' . $testimonial->sender->profilePhoto) }}" alt="Profile" class="rounded-circle img-thumbnail object-fit-cover" style="height: 100px;width:100px;">
                                                <h3>{{ $testimonial->sender->firstName . ' ' . $testimonial->sender->lastName }}
                                                </h3>
                                                <p class="text-center text-muted text-wrap p-testimonial-message"><i class="bi bi-quote text-dark" style="font-size: 20px;"></i>{{ $testimonial->message }}<i class="bi bi-quote text-dark" style="font-size: 20px;display:inline-block;transform:rotate(180deg);"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endauth

        {{-- end testimonial --}}

        <!-- Button trigger modal -->


        <!-- Modal -->
        @if ($nearestTraining)
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Join {{ $nearestTraining->title }}
                                Training
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 text-start">
                                    <p class="text-muted">
                                        <small>{{ $nearestTraining->venue }}</small>
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h6>
                                        {{ \Carbon\Carbon::parse($nearestTraining->date)->format('j M Y') }}
                                    </h6>
                                    <small class="text-muted">{{ $nearestTraining->time }}</small>
                                </div>
                            </div>
                        </div>
                        <style>
                            .modal-footers {
                                /* display: flex; */
                                */ flex-shrink: 0;
                                /* flex-wrap: wrap; */
                                align-items: center;
                                padding: calc(var(--bs-modal-padding) - var(--bs-modal-footer-gap)* .5);
                                background-color: var(--bs-modal-footer-bg);
                                border-top: var(--bs-modal-footer-border-width) solid var(--bs-modal-footer-border-color);
                                border-bottom-right-radius: var(--bs-modal-inner-border-radius);
                                border-bottom-left-radius: var(--bs-modal-inner-border-radius);

                            }
                        </style>
                        <div class="modal-footers">
                            <div class="d-flex justify-content-between">
                                <div class="text-start">
                                    @if ($nearestTraining->fees == 0)
                                        <h5 class="text-muted text-center">Free</h5>
                                    @else
                                        <h5 class="text-muted text-center amount"> ₹ {{ $nearestTraining->fees }}</h5>
                                    @endif
                                </div>
                                <div class="">
                                    @if (count($findRegister) == 0)
                                        @if ($nearestTraining->fees == 0)
                                            <a href="{{ route('training.register') }}/{{ $nearestTraining->id }}/{{ $nearestTraining->trainersTrainings->user->id }}" class="btn btn-primary">Register Now</a>
                                        @else
                                            <button type="button" class="btn btn-bg-blue pay">Pay Now</button>
                                        @endif
                                    @else
                                        <span class="text-muted">Already Registered</span>
                                    @endif
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- invite person modal --}}
        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Person Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="registrationForm" action="{{ route('invite.person') }}" method="POST">
                            @csrf
                            @if (!auth()->user()->hasRole('Admin'))
                                <input type="hidden" name="meetingId" id="meetingId" value="{{ $meeting->id }}">
                                <div class="mb-3">
                                    <label for="personName" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="personName" id="personName" required>
                                    <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                                </div>
                                <div class="mb-3">
                                    <label for="personEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" name="personEmail" id="personEmail" aria-describedby="emailHelp" required>
                                    <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                                </div>
                                <div class="mb-3">
                                    <label for="personContact" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" name="personContact" id="personContact" pattern="[0-9]{10}" maxlength="10" oninput="if(this.value.length > 10) this.value = this.value.slice(0,10); this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" required>
                                    <span class="error-message text-danger" id="phoneError" style="display:none;">
                                        Please enter correct number
                                    </span> <!-- Error message placeholder -->
                                </div>

                                <script>
                                    document.getElementById("personContact").addEventListener("input", function(e) {
                                        var x = document.getElementById("personContact").value;
                                        if (x.length == 10) {
                                            document.getElementById("phoneError").style.display = "none";
                                        } else {
                                            document.getElementById("phoneError").style.display = "block";
                                        }
                                    });
                                </script>
                                <div class="mb-3">
                                    <label for="personBusiness" class="form-label">Business Category</label>
                                    <select name="  businessCategoryId" class="form-select" id="personBusiness" required>
                                        <option value="" disabled selected>--Select Business Category--</option>
                                        @foreach ($businessCategory as $category)
                                            <option value="{{ $category->id }}"><img src="{{ asset('BusinessCategory') }}/{{ $category->image }}" alt=""> {{ $category->categoryName }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endif

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all elements with the 'pay-button' class
            var payButtons = document.querySelectorAll('.pay');
            console.log('pay buttons', payButtons);

            // Loop through each pay button and attach the click event handler
            payButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {

                    var amountElement = document.querySelector('.amount');
                    var amountText = amountElement ? amountElement.textContent.trim() : '';
                    var amount = parseInt(amountText.replace('₹', '').trim()) * 100;

                    console.log('amount:', amount);

                    var razorpayKey = "{{ env('RAZORPAY_KEY') }}";
                    console.log('Razorpay Key:', razorpayKey);

                    // Ensure that the Razorpay key is available
                    if (!razorpayKey) {
                        console.error('Razorpay key is missing.');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Payment configuration error. Please contact support.',
                        });
                        return;
                    }

                    var username = "{{ Auth::user()->name }}";
                    var useremail = "{{ Auth::user()->email }}";
                    console.log('username:', username);
                    console.log('useremail:', useremail);

                    var options = {
                        "key": razorpayKey,
                        "amount": amount,
                        "currency": "INR",
                        "name": "UBN",
                        "description": "Razorpay payment",
                        "image": "/img/logo.png",
                        "handler": function(response) {
                            // Handle the response after payment
                            console.log('Payment response:', response);
                            var paymentId = response.razorpay_payment_id;
                            storePaymentId(paymentId, amount);
                        },
                        "prefill": {
                            "name": username,
                            "email": useremail
                        },
                        "theme": {
                            "color": "#012e6f"
                        }
                    };

                    var rzp = new Razorpay(options);
                    rzp.open();
                });
            });
        });


        function storePaymentId(paymentId = '', amount = '') {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = `{{ route('razorpay.payment.store') }}`;
            var trainingId = $('.trainingId').val();
            // var trainingId2 =
            // var trainerId = '{{ $nearestTraining->trainersTrainings[0]->user ?? '-' }}';

            console.log('my training id:', trainingId);
            // console.log('trainerId:', trainerId);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        paymentId: paymentId,
                        amount: amount,
                        trainingId: trainingId,
                        // trainerId: trainerId
                    }),
                })
                .then(response => {
                    // Handle the response from the server
                    console.log('Payment ID stored successfully');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Payment Successful',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error storing payment ID: ', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to store payment ID',
                    });
                });
        }
    </script>

    {{-- validation --}}
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                var isValid = true; // Flag to track overall form validity

                // Reset error messages
                $('.error-message').text('');

                // Validate each input field and select element
                $('#registrationForm input, #registrationForm select').each(function() {
                    var input = $(this);
                    var errorSpan = input.next('.error-message');
                    var value = input.val().trim(); // Trim value before validation

                    // Check if field is empty
                    if (value === '') {
                        errorSpan.text('This field is required.');
                        isValid = false; // Set flag to false if any field is invalid
                    }

                    // Additional validation for specific fields
                    if (input.attr('name') === 'personEmail' && !isValidEmail(value)) {
                        errorSpan.text('Please enter a valid email address.');
                        isValid = false;
                    }

                    // You can add more specific validation rules for other fields here
                });

                // Validate dropdown (select) element
                var selectElement = $('#personBusiness');
                var selectErrorSpan = selectElement.next('.error-message');
                if (selectElement.val() === null || selectElement.val() === '') {
                    selectErrorSpan.text('Please select a business category.');
                    isValid = false;
                }

                // If form is valid, submit the form
                if (isValid) {
                    this.submit();
                }
            });
        });

        // Function to check if email is valid
        function isValidEmail(email) {
            // This regex checks for a basic email format
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>

    <!-- sweetalert -->
@endsection
