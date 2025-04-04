@extends('layouts.master')

@section('title', 'UBN - Dashboard')
@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


    {{-- <div class="container"> --}}




        @role('Member')
            {{-- Upcoming Circle Meeting start --}}
            @include('components.birthdayWishes')
            {{-- Upcoming Circle Meeting end --}}


            {{-- Home Card Count start --}}
            @include('components.homeCards')
            {{-- Home Card Count end --}}

            {{-- Upcoming Circle Meeting start --}}
            {{-- @include('components.circleMeetings') --}}
            {{-- Upcoming Circle Meeting end --}}


            {{-- leaderboard start --}}
            {{-- @include('components.leaderboard') --}}
            {{-- leaderboard end --}}


            {{-- Upcoming Training start --}}
            @include('components.trainingSection')
            {{-- Upcoming Training end --}}


            {{-- Upcoming Event start --}}
            {{-- @include('components.upcomingEvent') --}}
            {{-- Upcoming Event end --}}


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




        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




        {{-- monthly payment reminder and view code start --}}
        {{-- @include('components.monthlyPaymentReminder') --}}
        {{-- monthly payment reminder and view code end --}}
    @endrole




    @role('Admin')
        @include('components.adminDash')
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
        {{-- <div class="modal fade" id="allInvitesModal" tabindex="-1" aria-labelledby="allInvitesModalLabel" aria-hidden="true">
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
                                            <td>{{ $invite->training->title ?? '' }}</td>
                                            <td>{{ $invite->user->firstName ?? '' }} {{ $invite->user->lastName ?? '' }}</td>
                                            <td>{{ $invite->personName ?? '' }}</td>
                                            <td>{{ $invite->personEmail ?? '' }}</td>
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
        </div> --}}
    @endrole



    {{-- Invited People Admin Side End --}}




    {{-- Testimonial --}}

    @include('components.testimonialSection')

    {{-- Testimonial End --}}


    {{-- @include('components.trainingSection') --}}

    <!-- sweetalert -->
@endsection
