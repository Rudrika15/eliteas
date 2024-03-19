@extends('layouts.master')

@section('header', 'Circle Meeting Member Business')
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
        <h5 class="card-title">Circle Meeting Member Business</h5>
        <a href="{{ route('busGiver.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="circleMemberBusForm" enctype="multipart/form-data" method="post"
        action="{{ route('busGiver.store') }}" novalidate>
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                {{-- <div class="form-floating">
                    <select class="form-control" data-error=' Field is required' required name="businessGiver"
                        id="businessGiver">
                        <option value="" selected disabled> Select Business Giver Member </option>
                        @foreach ($member as $memberData)
                        <option value="{{ $memberData->id }}">{{ $memberData->firstName }} {{
                            $memberData->lastName }}</option>
                        @endforeach
                    </select>
                    @error('businessGiver')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div> --}}
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-6">
                    <input type="text" class="form-control @error('businessGiver') is-invalid @enderror"
                        id="businessGiver" name="businessGiver" placeholder="Reference Giver" required>
                    <label for="businessGiver">Business Giver</label>
                    @error('businessGiver')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('loginMember') is-invalid @enderror" id="loginMember"
                        name="loginMember" placeholder="Contact Name" required>
                    <label for="loginMember">Login Member</label>
                    @error('loginMember')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('contactNo') is-invalid @enderror" id="amount"
                        name="amount" placeholder="Amount" required>
                    <label for="amount">Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                        placeholder="date" required>
                    <label for="date">Date</label>
                    @error('date')
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