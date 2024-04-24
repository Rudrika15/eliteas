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
        <h5 class="card-title">Edit Train Master</h5>
        <a href="{{ route('trainer.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="trainmasterForm" enctype="multipart/form-data" method="post"
        action="{{ route('trainer.update', $trainer->id) }}" novalidate>
        @csrf
        <input type="hidden" name="id" value="{{ $trainer->id }}">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                        name="firstName" placeholder="First Name" required value="{{$trainer->firstName}}">
                    <label for="firstName">First Name</label>
                    @error('firstName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                        name="lastName" placeholder="Last Name" required value="{{$trainer->lastName}}">
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
                        placeholder="Email" required value="{{$trainer->email}}">
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
                        name="contactNo" placeholder="Contact No" required value="{{$trainer->contactNo}}">
                    <label for="contactNo">Contact No</label>
                    @error('contactNo')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        
        
        </div>



        <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection