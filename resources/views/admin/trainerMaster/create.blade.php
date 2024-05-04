@extends('layouts.master')

@section('header', 'Train Master')
@section('content')

{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        {{-- <i class="fa fa-times"></i> --}}
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif


<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Create Train Master</h5>
        <a href="{{ route('trainer.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="trainmasterForm" enctype="multipart/form-data" method="post"
        action="{{ route('trainer.store') }}" novalidate>
        @csrf



        <div class="row">
            <div class="col-md-6">
                <!-- Trainer selection -->
                <div class="form-check">
                    <input class="form-check-input trainer-radio" type="radio" name="type" id="internal"
                        value="internalMember" checked>
                    <label class="form-check-label" for="internalMember">Internal</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input trainer-radio" type="radio" name="type" id="external"
                        value="externalMember">
                    <label class="form-check-label" for="externalMember">External</label>
                </div>

                <!-- Member selection -->
                <div class="member-list" id="memberListDropdownMember">
                    @include('InternalTrainer')
                    <input type="hidden" name="trainerId" id="trainerId">
                    <input type="text" class="form-control mt-3" id="trainerName" name="memberName"
                        placeholder="Select Member" readonly>
                    <input type="text" class="form-control mt-3" id="trainerContact" name="contactNo"
                        placeholder="Contact No" readonly>
                    <input type="text" class="form-control mt-3" id="trainerEmail" name="email" placeholder="Email" readonly>
                </div>
                {{-- <div class="externalTrainer" id="externalTrainer" name="externalTrainer">
                    <input type="hidden" name="externalTrainerId" id="externalTrainerId"> --}}
                    {{-- <input type="text" class="form-control mt-3" id="trainerNameExternal"
                        name="trainerNameExternal" placeholder="Trainer Name External"> --}}
                {{-- </div> --}}

                <!-- Contact details -->
            </div>
        </div>

        {{-- external Trainers Details --}}

        
        
        <div class="row mb-3 externalTrainer">
            <br>
            <b>External Trainer Details</b>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                        name="firstName" placeholder="Train Name">
                    <label for="firstName">First Name</label>
                    @error('firstName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                        name="lastName" placeholder="Train Name">
                    <label for="lastName">Last Name</label>
                    @error('lastName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                        placeholder="Train Name">
                    <label for="email">Email</label>
                    @error('email')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="contactNo"
                        name="contactNo" placeholder="Contact No">
                    <label for="contactNo">Contact No</label>
                    @error('contactNo')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>


        </div>
        <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function(){
        $('.externalTrainer').hide();

        $('.trainer-radio').change(function(){
            var selectedVal = $(this).val();

            if(selectedVal == 'externalMember'){
                $('.member-list').hide();
                $('.externalTrainer').show();
            }else{
                $('.member-list').show();
                $('.externalTrainer').hide();
            }
        });
    });
</script>


@endsection