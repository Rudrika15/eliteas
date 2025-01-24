@extends('layouts.master')

@section('title', 'UBN - Event Member')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Add Event Member</h5>
            <a href="{{ route('event.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <hr>
        <form class="m-3 needs-validation" id="circlecallForm" enctype="multipart/form-data" method="post" action="{{ route('addEventMember.store') }}" novalidate>
            @csrf

            <input type="hidden" name="eventId" value="{{ request()->route('id') }}">

            <div class="row mb-3 mt-3">
                <!-- Circle Dropdown -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('circleId') is-invalid @enderror" id="circleId" name="circleId" required>
                            <option value="" selected disabled>Select Circle</option>
                            <option value="{{ old('circleId') }}" selected>
                                {{ $circles->where('id', old('circleId'))->first()->circleName ?? '' }}</option>
                            @foreach ($circles as $circle)
                                <option value="{{ $circle->id }}">{{ $circle->circleName }}</option>
                            @endforeach
                        </select>
                        <label for="circleId">Circle</label>
                        @error('circleId')
                            <div class="invalid-tooltip">
                                This field is required.
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Member Dropdown -->
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('memberId') is-invalid @enderror" id="memberId" name="memberId" required>
                            <option value="">Select Member</option>
                            <!-- Options will be populated dynamically -->
                        </select>
                        <label for="memberId">Member</label>
                        @error('memberId')
                            <div class="invalid-tooltip">
                                This field is required.
                            </div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('personName') is-invalid @enderror" id="personName" name="personName" placeholder="Person Name" value="{{ old('personName') }}" />
                        <label for="personName">Visitor Name</label>
                        @error('personName')
                            {{-- <div class="invalid-tooltip">
                                This field is required.
                            </div> --}}
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="email" class="form-control @error('personEmail') is-invalid @enderror" id="personEmail" name="personEmail" placeholder="Email" value="{{ old('personEmail') }}" />
                        <label for="personEmail">Visitor Email</label>
                        @error('personEmail')
                            {{-- <div class="invalid-tooltip">
                                This field is required.
                            </div> --}}
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('personContact') is-invalid @enderror" id="personContact" name="personContact" placeholder="Contact" value="{{ old('personContact') }}" />
                        <label for="personContact">Visitor Contact</label>
                        @error('personContact')
                            {{-- <div class="invalid-tooltip">
                                This field is required.
                            </div> --}}
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('refMemberId') is-invalid @enderror" id="refMemberId" name="refMemberId" placeholder="Reference Member" value="{{ old('refMemberId') }}" />
                        <label for="refMemberId">Invited By</label>
                        @error('refMemberId')
                            <div class="invalid-tooltip">
                                This field is required.
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('paymentStatus') is-invalid @enderror" id="paymentStatus" name="paymentStatus" required>
                            <option value="" selected disabled>Select Payment Status</option>
                            <option value="Paid" {{ old('paymentStatus') == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Unpaid" {{ old('paymentStatus') == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        <label for="paymentStatus">Payment Status</label>
                        @error('paymentStatus')
                            <div class="invalid-tooltip">
                                This field is required.
                            </div>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="text-center mt-5">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                {{-- <button type="reset" class="btn btn-bg-orange">Reset</button> --}}
            </div>
        </form><!-- End floating Labels Form -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#circleId').change(function() {
                const circleId = $(this).val();
                const memberDropdown = $('#memberId');

                // Clear existing options
                memberDropdown.empty().append('<option value="">Select Member</option>');

                if (circleId) {
                    $.ajax({
                        url: '{{ url('/get-members') }}/' + circleId,
                        type: 'GET',
                        data: {
                            circleId
                        },
                        success: function(response) {
                            if (response.length > 0) {
                                response.forEach(member => {
                                    memberDropdown.append(
                                        `<option value="${member.id}">${member.firstName} ${member.lastName}</option>`
                                    );
                                });
                            } else {
                                memberDropdown.append('<option value="">No members available</option>');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            alert('Failed to fetch members. Please try again.');
                        }
                    });
                }
            });
        });
    </script>


@endsection
