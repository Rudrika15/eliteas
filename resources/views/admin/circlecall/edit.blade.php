@extends('layouts.master')

@section('title', 'UBN - Business Meet')
@section('content')

<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Edit Business Meet</h5>
        <a href="{{ route('circlecall.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>
    <hr>
    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="callForm" enctype="multipart/form-data" method="post"
        action="{{ route('circlecall.update', $circlecall->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $circlecall->id }}">

        @include('circleMemberMaster')

        <div class="row mb-3 mt-3">
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="hidden" id="meetingPersonId" name="meetingPersonId"
                        value="{{ $circlecall->meetingPersonId }}" required>

                    <input type="text" class="form-control " readonly id="meetingPersonName" placeholder="Select Member"
                        value="{{ $circlecall->meetingPerson->firstName }} {{ $circlecall->meetingPerson->lastName }}"
                        disabled required>
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
                    <input type="text" class="form-control @error('meetingPlace') is-invalid @enderror"
                        id="meetingPlace" name="meetingPlace" placeholder="Meeting Place Name"
                        value="{{ $circlecall->meetingPlace }}" required>
                    <label for="meetingPlace">Meeting Place Name</label>
                    @error('meetingPlace')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="file" class="form-control @error('meetingImage') is-invalid @enderror" id="meetingImage" value="{{ $circlecall->meetingImage }}" name="meetingImage" accept="image/*" required onchange="previewPhoto(event)">
                    <label for="meetingImage">Upload Meeting Image</label>
                    @error('meetingImage')
                    <div class="invalid-tooltip">
                        This field is required.
                    </div>
                    @enderror
                </div>
            
                <!-- Photo Preview Section -->
                <div class="mt-1">
                    <img id="photoPreview" src="" alt="Meeting Image" style="width: 50%; height: 50%; object-fit: contain; aspect-ratio: 1/1;" />
                </div>
            </div>

            <script>
                function previewPhoto(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('photoPreview');
                
                    if (file) {
                        const reader = new FileReader();
                
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block'; // Show the image
                        }
                
                        reader.readAsDataURL(file); // Read the file as a data URL
                    }
                }
            </script>


            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="date" class="form-control" id="date" name="date" placeholder="Meeting Date" disabled
                        value="{{ $circlecall->date }}">
                    <label for="date">Date</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks"
                        name="remarks" placeholder="Remarks" value="{{ $circlecall->remarks }}" required>
                    <label for="remarks">Remarks</label>
                    @error('remarks')
                    <div class="invalid-tooltip">
                        {{ $message }}
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

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
            $('#callForm').validate({
                rules: {
                    meetingPersonId: {
                        required: true
                    },
                    meetingPlace: {
                        required: true
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