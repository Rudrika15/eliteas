@extends('layouts.master')

@section('title', 'UBN - Business Slip')
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
        <div class="d-flex justify-content-between align-items-center mt-3 mb-5">
            <h4 class="card-title">Circle Member Business</h4>
            <a href="{{ route('busGiver.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>
        <hr class="mb-5">
        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="circleMemberBusForm" enctype="multipart/form-data" method="post"
            action="{{ route('busGiver.update', $busGiver->id ) }}" novalidate>
            @csrf

            {{-- <div class="col-md-6"> --}}
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
                {{-- </div> --}}
            <div class="">

                <div class="form-floating mt-6">
                    <input type="hidden" name="businessGiverId" id="businessGiverId"
                        value="{{ $busGiver->businessGiverId }}">
                    <input type="text" class="form-control @error('businessGiver') is-invalid @enderror"
                        id="businessGiver" name="businessGiver"
                        value="{{ $busGiver->businessGiver->firstName . ' ' . $busGiver->businessGiver->lastName }}"
                        placeholder="Reference Giver" readonly required>
                    <label for="businessGiver">Business Giver</label>
                    @error('businessGiver')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <input type="hidden" name="loginMemberId" value="{{ $busGiver->loginMemberId }}">
            {{-- <div class="col-md-6">
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
            </div> --}}
            <div class="">
                <div class="form-floating mt-3">
                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                        name="amount" placeholder="Amount" required
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    <label for="amount">Amount</label>
                    @error('amount')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="">
                <div class="form-floating mt-3">
                    <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date"
                        placeholder="date" required max="{{ date('Y-m-d') }}"
                        value="{{ old('date', $busGiver->date) }}">
                    <label for="date">Date</label>
                    @error('date')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-5">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                {{-- <button type="reset" class="btn btn-bg-orange">Reset</button> --}}
            </div>
        </form><!-- End floating Labels Form -->
    </div>
</div>



<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h4 class="mb-0 mt-3 text-blue">Business Slip Payment History</h4>
            {{-- <a href="{{ route('busGiver.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a> --}}
        </div>
        <hr class="mb-5">
        <!-- Table with stripped rows -->
        <table class="table datatable table-striped table-hover mb-5">
            <thead>
                <tr>
                    {{-- <th>Business Giver</th> --}}
                    <th>Amount</th>
                    <th>Date</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($paymentHistory->isNotEmpty())
                @foreach ($paymentHistory as $paymentHistoryData)
                <tr>
                    <td>{{ number_format($paymentHistoryData->amount, 2, '.', ',') ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($paymentHistoryData->date)->format('d-m-Y') ?? '-' }}</td>
                    {{-- <td>{{$paymentHistoryData->status ?? '-'}}</td> --}}
                    <td><a href="{{ route('busGiver.updatePayment', $paymentHistoryData->id) }}"
                            class="btn btn-bg-blue btn-sm"><i class="bi bi-pen"></i></a></td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="5" class="text-center">No payment history data available</td>
                </tr>
                @endif
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
</div>

@endsection