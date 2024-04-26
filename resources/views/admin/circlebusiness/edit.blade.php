@extends('layouts.master')

@section('title', 'UBN - Circle Business')

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
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="text-blue mt-3">Edit Meeting Member Reference Giver</h4>
                <a href="{{ route('busGiver.index') }}" class="btn btn-bg-blue mt-3 btn-sm">BACK</a>
            </div>
            <hr>
            <!-- Floating Labels Form -->
            <form class="m-3 needs-validation" id="businessGiverForm" enctype="multipart/form-data" method="post"
                action="{{ route('busGiver.update', $busGiver->id) }}" novalidate>
                @csrf
                <input type="hidden" name="id" value="{{ $busGiver->id }}">
                <div class="row mb-3 mt-5">
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
                                id="businessGiver" name="businessGiver" placeholder="Reference Giver"
                                value="{{ $busGiver->businessGiver }}" required>
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
                            <input type="text" class="form-control @error('loginMember') is-invalid @enderror"
                                id="loginMember" name="loginMember" placeholder="Contact Name"
                                value="{{ $busGiver->loginMember }}" required>
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
                            <input type="text" class="form-control @error('contactNo') is-invalid @enderror"
                                id="amount" name="amount" placeholder="Amount" value="{{ $busGiver->amount }}" required>
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
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" placeholder="date" value="{{ $busGiver->date }}" required>
                            <label for="date">Date</label>
                            @error('date')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </form><!-- End floating Labels Form -->
        </div>
    </div>

@endsection
