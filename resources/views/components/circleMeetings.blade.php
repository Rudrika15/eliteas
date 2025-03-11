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
            @if ($categoryNames->isNotEmpty())
                <div class="col-md-7">
                @else
                    <div class="col-md-12">
            @endif
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
                        <div class="col-md-10 ps-3 card-title ">Invite people to join</div>
                        <div class="col-md-2 mt-2 pe-3">
                            {{-- <button type="button" class="btn btn-bg-orange btn-sm mt-2"
                                    onclick="openInvitePage('{{ $meeting->cm_slug }}', '{{ $meeting->id }}', '{{ auth()->user()->member->id }}')"
                                    target="_blank">
                                    Invite
                                </button> --}}

                            <button type="button" class="btn btn-bg-orange btn-sm mt-2 " onclick="openInvitePage('{{ $signedUrl }}')">
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
        @if ($categoryNames->isNotEmpty())
            <div class="col-5">
                <div class="card-title"><b>Top Categories</b></div>
                <div class="card border-0 shadow workshopCard">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    @foreach ($categoryNames as $categoryName)
                                        <div class="col-md-6">
                                            <div class="card mb-3 mt-3 categoryCard">
                                                <div class="card-body p-2">
                                                    <h5 class="card-title">{{ $categoryName }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- <p>No categories available at this time.</p> --}}
        @endif
    </div>

@endif

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
