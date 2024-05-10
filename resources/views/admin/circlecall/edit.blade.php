@extends('layouts.master')

@section('title', 'UBN - 1:1 Meeting')
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
        <h5 class="card-title">Edit Call Meeting</h5>
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
            <div class="col-md-12">
                <div class="form-floating mt-3">
                    <input type="hidden" id="meetingPersonId" name="meetingPersonId"
                        value="{{ $circlecall->meetingPersonId }}">
                    <input type="text" class="form-control" readonly id="meetingPersonName" placeholder="Select Member"
                        value="{{ $circlecall->meetingPerson->firstName }} {{ $circlecall->meetingPerson->lastName }}">
                    <label for="memberName">Meeting Person Name</label>
                    @error('memberId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>

        {{-- <div class="row mb-3"> --}}
            {{-- <div class="col-md-6"> --}}
                <div class="form-floating mt-3">
                    <input type="text" class="form-control @error('meetingPlace') is-invalid @enderror"
                        id="meetingPlace" name="meetingPlace" placeholder="Meeeting Place Name"
                        value="{{ $circlecall->meetingPlace }}" required>
                    <label for="meetingPlace">Meeting Place Name</label>
                    @error('meetingPlace')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <?php
                            use Illuminate\Support\Carbon;
                                    
                            $nearestDate = $scheduleDate->min();
                            $nearestDate = $nearestDate ? Carbon::parse($nearestDate)->subDay()->format('Y-m-d') : Carbon::now()->format('Y-m-d');
                            // $startDate = Carbon::now()->subDay(15)->format('Y-m-d');
                            // $nearestDate = '2024-04-24';
                            // $startDate = $lastDate;
                            
                            ?>
                            
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                            name="date" placeholder="Meeting Date" required min="{{ $lastDate }}"
                            max="{{ $nearestDate }}" value="{{ old('date', $circlecall->date) }}">
                        <label for="date">Date</label>
                        @error('date')
                        <div class="invalid-tooltip">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

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
                <div class="text-center mt-5 ">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>

    </form><!-- End floating Labels Form -->
</div>
@endsection