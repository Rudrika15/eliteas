@extends('layouts.master')

@section('title', 'UBN - Dashboard')
@section('content')
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

    @role('Member')
    <div class="row">
        <div class="col-md-4">
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
        </div>

        <div class="col-md-4">
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
                        {{-- <h2>{{ $count }}</h2> --}}
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
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
                        {{-- <h2>{{ $count }}</h2> --}}
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
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
                        {{-- <h2>{{ $count }}</h2> --}}
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('maxVisitor.index') }}" class="card-link">
                <div class="card shadow">
                    <div class="card-header">
                        <b style="color: #1d2856;">Visitors</b>
                        <i class="bi bi-people"
                            style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
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
    </div>

    <div class="container-responsive">.
        <div class="row">
            @if ($meeting)
            <div class="col-md-12">
                <div class="card-title"><b>Upcoming Circle Meetings</b></div>
                <div class="card border-0 shadow workshopCard">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">{{ $meeting->circle->circleName }}
                                    <span class="text-muted">( {{ $meeting->circle->city->cityName }} )</span>
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
                            <div class="col-md-1 mt-2 ">
                                <button type="button" class="btn btn-bg-orange btn-sm mt-2" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Invite
                                </button>
                            </div>
                        </div>
                        <div class="accordion mt-3">
                            <div class="accordion-item ">
                                <div class="accordion-header" id="headingSix">

                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
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
                                                        <td colspan="2" class="text-muted text-center">No Invites for
                                                            current
                                                            meeting</td>
                                                    </tr>
                                                    @else
                                                    @foreach ($myInvites as $invite)
                                                    <tr>
                                                        <td><small class="text-muted">{{ $invite->personName }}</small>
                                                        </td>
                                                        <td><small class="text-muted">{{ $invite->personEmail }}</small>
                                                        <td><small class="text-muted">{{ $invite->personContact
                                                                }}</small>
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
            @else
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    No upcoming circle meeting found
                </div>
            </div>
            @endif
        </div>
    </div>



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
                        </div>

                        <div class="col-md-2 pt-3 text-muted text-end">
                            <b>Date : </b> {{ \Carbon\Carbon::parse($nearestTraining->date)->format('j M Y')
                            }} <br>
                            <b>Time :</b> {{ $nearestTraining->time }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mt-4">
                            <p class="text-muted"><strong>Trainer Details:</strong><br>
                                <small class="fw-italic text-muted pt-2 fw-italic">
                                    {{ $nearestTraining->trainersTrainings->user->firstName ?? '-' }}
                                    {{ $nearestTraining->trainersTrainings->user->lastName ?? '-' }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    {{ $nearestTraining->trainersTrainings->user->email ?? '-' }}
                                </small>
                            </p>
                        </div>
                        <div class="col-md-4">
                            @if (count($findRegister) == 0)
                            @if ($nearestTraining->fees == 0)
                            <h5 class="text-muted text-end me-4 pt-5">Free</h5>
                            <button type="button" class="btn btn-bg-blue btn-md" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                Register
                            </button>
                            @else
                            <h5 class="text-muted text-end me-4 pt-3"> ₹
                                {{ $nearestTraining->fees }}
                            </h5>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-bg-blue btn-md " data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop">
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
@endrole




@role('Admin')
<div class="row">
    <div class="col-md-4">
        <a href="{{ route('schedule.dashIndex') }}" class="card-link">
            <div class="card shadow">
                <div class="card-header">
                    <b style="color: #1d2856;">Upcoming Circle Meetings</b>
                    <i class="bi bi-calendar3"
                        style="display: inline-block; float: right; color: rgb(255, 187, 0);"></i>
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

    <div class="col-md-4">
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
                    {{-- <h2>{{ $count }}</h2> --}}
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
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
    </div>

    <div class="col-md-4">
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
                    {{-- <h2>{{ $count }}</h2> --}}
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
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
                    {{-- <h2>{{ $count }}</h2> --}}
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
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
                    {{-- <h2>{{ $count }}</h2> --}}
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-4">
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
                    {{-- <h2>{{ $count }}</h2> --}}
                </div>
            </div>
        </a>
    </div>
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
                                <td
                                    style="background-color: {{ $statusColors[$invite->paymentStatus] ?? 'red' }}; color: white;">
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
                            <img src="{{ asset('ProfilePhoto/' . $testimonial->sender->profilePhoto) }}" alt="Profile"
                                class="rounded-circle img-thumbnail object-fit-cover"
                                style="height: 100px;width:100px;">
                            <h3>{{ $testimonial->sender->firstName . ' ' . $testimonial->sender->lastName }}
                            </h3>
                            <p class="text-center text-muted text-wrap p-testimonial-message"><i
                                    class="bi bi-quote text-dark" style="font-size: 20px;"></i>{{
                                $testimonial->message
                                }}<i class="bi bi-quote text-dark"
                                    style="font-size: 20px;display:inline-block;transform:rotate(180deg);"></i>
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
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
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Join {{ $nearestTraining->title }} Training
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
                        <a href="{{ route('training.register') }}/{{ $nearestTraining->id }}/{{ $nearestTraining->trainersTrainings->user->id }}"
                            class="btn btn-primary">Register Now</a>
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
                        <input type="email" class="form-control" name="personEmail" id="personEmail"
                            aria-describedby="emailHelp" required>
                        <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                    </div>
                    <div class="mb-3">
                        <label for="personContact" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" name="personContact" id="personContact"
                            pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
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
                            <option value="{{ $category->id }}"><img
                                    src="{{ asset('BusinessCategory') }}/{{ $category->image }}" alt=""> {{
                                $category->categoryName }}</option>
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
            console.log('pay', payButtons);
            // Loop through each pay button and attach the click event handler
            payButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {

                    var amountElement = document.querySelector('.amount');
                    var amountText = amountElement.textContent.trim();
                    var amount = parseInt(amountText.replace('₹', '').trim()) * 100;

                    console.log('amount', amount);
                    console.log('pay button', payButtons);

                    username = "{{ Auth::user()->name }}";
                    useremail = "{{ Auth::user()->email }}";
                    console.log('username', username);

                    var options = {
                        "key": "{{ env('RAZORPAY_KEY') }}",
                        "amount": amount,
                        "currency": "INR",
                        "name": "UBN",
                        "description": "Razorpay payment",
                        "image": "/img/logo.png",
                        "handler": function(response) {
                            // Handle the response after payment
                            console.log(response);
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
            var trainingId = '{{ $nearestTraining->id ?? '-' }}';
            var trainerId = '{{ $nearestTraining->trainersTrainings->user->id ?? '-'}}';
            console.log('trainingId', trainingId);
            console.log('trainerId', trainerId);
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
                        trainerId: trainerId
                    }),
                })
                .then(response => {
                    // Handle the response from the server
                    console.log('Payment ID stored successfully');
                    // Display SweetAlert success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Payment Successfull',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error storing payment ID: ', error);
                    // Display SweetAlert error message
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