@extends('layouts.master')

@section('header', 'Visitor')
@section('content')

    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Visitor Remarks</h5>
            <a href="{{ route('visitors.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="visitorsForm" enctype="multipart/form-data" method="post" action="{{ route('visitors.remarksUpdate', $visitors->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $visitors->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value="{{ $visitors->firstName }}" readonly>
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
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" value="{{ $visitors->lastName }}" readonly>
                        <label for="lastName">Last Name</label>
                        @error('lastName')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <textarea class="form-control" id="remarks" name="remarks" placeholder="Follow-Up Remarks"></textarea>
                        <label for="remarks">Follow-Up Remarks</label>
                        @error('remarks')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Visitor Follow-Up</h4>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Follow-Up Details</th>
                            <th class="text-center">Date & Time</th>
                            <th class="text-center">Follow Up By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitorRemarks as $visitorRemarksData)
                            <tr>
                                <td>{{ $visitorRemarksData->remarks ?? '' }}</td>
                                <td>{{ \Carbon\Carbon::parse($visitorRemarksData->date)->format('d-m-y h:i A') ?? '' }}</td>
                                <td>{{ $visitorRemarksData->users->firstName }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
