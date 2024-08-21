@extends('layouts.master')

@section('title', 'UBN - Business Meet')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Success!</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert"></button>
    <strong>Error!</strong> {{ session('error') }}
</div>
@endif --}}


<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Create Business Meet</h5>
        <a href="{{ route('circlecall.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>
    <hr>
    <form class="m-3 needs-validation" id="circlecallForm" enctype="multipart/form-data" method="post"
        action="{{ route('circlecall.store') }}" novalidate>
        @csrf

        @include('circleMemberMaster')

        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="hidden" id="meetingPersonId" name="meetingPersonId" required>
                    <input type="text" class="form-control @error('meetingPersonId') is-invalid @enderror" readonly
                        id="meetingPersonName" placeholder="Select Member" disabled required>
                    <label for="memberName">Meeting Person Name</label>
                    @error('meetingPersonId')
                    <div class="invalid-tooltip">
                        This field is required.
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="meetingPlace" name="meetingPlace"
                        placeholder="Meeting Place Name" pattern="[A-Za-z\s]+" required
                        oninvalid="this.setCustomValidity('Please enter correct details.')"
                        oninput="setCustomValidity('')">
                    <label for="meetingPlace">Meeting Place Name</label>
                    <span class="error-message text-danger"></span> <!-- Error message placeholder -->
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <?php
                        use Illuminate\Support\Carbon;
                        
                        $nearestDate = $scheduleDate->min();
                        $nearestDate = $nearestDate ? Carbon::parse($nearestDate)->subDay()->format('Y-m-d') : Carbon::now()->format('Y-m-d');
                        $selectedDate = request()->input('date') ?? (Carbon::now()->format('Y-m-d') == $nearestDate ? Carbon::now()->format('Y-m-d') : $nearestDate);
                        ?>
                    <input type="date" class="form-control" id="date" name="date" placeholder="Meeting Date" required
                        min="{{ $lastDate }}" max="{{ $nearestDate }}" value="{{ $selectedDate }}">
                    <label for="date">Date</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks" required>
                    <label for="remarks">Remarks</label>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
            $('#circlecallForm').validate({
                rules: {
                    meetingPersonId: {
                        required: true
                    },
                    meetingPlace: {
                        required: true
                    },
                    date: {
                        required: true,
                        date: true
                    },
                    remarks: {
                        required: true
                    }
                },
                messages: {
                    meetingPersonId: {
                        required: "Please select a meeting person."
                    },
                    meetingPlace: {
                        required: "Please enter the meeting place."
                    },
                    date: {
                        required: "Please select a date."
                    },
                    remarks: {
                        required: "Please enter remarks."
                    }
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-tooltip');
                    element.closest('.form-floating').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                }
            });
        });
</script>
@endsection