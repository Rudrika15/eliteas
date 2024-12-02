@extends('layouts.master')

@section('header', 'Coupon')
@section('content')

{{-- Message --}}


<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Create Coupon</h5>
        <a href="{{ route('coupon.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>

    <!-- Floating Labels Form -->
    <form class="m-3 needs-validation" id="couponForm" enctype="multipart/form-data" method="post"
        action="{{ route('coupon.store') }}" novalidate>
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <select class="form-select @error('eventId') is-invalid @enderror" id="eventId" name="eventId"
                        required>
                        <option value="" selected disabled>Select Event</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                    <label for="eventId">Event</label>
                    @error('eventId')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('couponName') is-invalid @enderror"
                        id="couponName" name="couponName" placeholder="Coupon Name" required>
                    <label for="couponName">Coupon Name</label>
                    @error('couponName')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="text" class="form-control @error('couponCode') is-invalid @enderror"
                        id="couponCode" name="couponCode" placeholder="Coupon Code" required>
                    <label for="couponCode">Coupon Code</label>
                    @error('couponCode')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                        name="amount" placeholder="Amount" required>
                    <label for="amount">Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form><!-- End floating Labels Form -->
</div>

@endsection
