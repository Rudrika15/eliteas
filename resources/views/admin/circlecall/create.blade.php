@extends('layouts.master')

@section('header', 'Circle 1:1 Meeting')
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
        <h5 class="card-title">Create 1:1 Meeting</h5>
        <a href="{{ route('circlecall.index') }}" class="btn btn-secondary btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="circlecallForm" enctype="multipart/form-data" method="post"
        action="{{ route('circlecall.store') }}" novalidate>
        @csrf
        {{-- circlememberId stor baki --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Member Field is required' required name="memberId"
                        id="memberId">
                        <option value="" selected disabled> Select Member </option>
                        @foreach ($member as $memberData)
                            @if (auth()->user()->id !== $memberData->id)
                                <option value="{{ $memberData->id }}">{{ $memberData->firstName }} {{
                                    $memberData->lastName }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('memberId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-control" data-error='Circle Meeting Field is required' required
                        name="circleMemberId" id="circleMemberId">
                        <option value="" selected disabled> Select Circle Member </option>
                        @foreach ($circleMember as $circleMemberData)
                        <option value="{{ $circleMemberData->id }}">{{ $circleMemberData->member->memberId ?? '-' }}
                            {{
                            $circleMemberData->circle->circleName ?? '-'}}</option>
                        @endforeach
                    </select>
                    @error('circleMemberId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div> --}}
            <div class="col-md-6">
                <div class="form-floating mt-6">
                    <input type="text" class="form-control @error('meetingPerson') is-invalid @enderror"
                        id="meetingPerson" name="meetingPerson" placeholder="Meeeting Person Name" required>
                    <label for="meetingPerson">Meeting Person Name</label>
                    @error('meetingPerson')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('meetingPlace') is-invalid @enderror"
                        id="meetingPlace" name="meetingPlace" placeholder="Meeeting Place Name" required>
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
                    <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks"
                        name="remarks" placeholder="Remarks" required>
                    <label for="remarks">Remarks</label>
                    @error('remarks')
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