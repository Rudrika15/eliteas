@extends('layouts.master')

@section('title', 'UBN - Circle Business')
@section('content')

    {{-- Message
@if (Session::has('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ session('success') }}</strong>
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="card-title">Business Slip Received</h4>
                            {{-- <a href="{{ route('busGiver.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a> --}}
                        </div>
                        <hr class="mb-5">
                        <!-- Table with stripped rows -->
                        <div class="table-responsive mt-5">
                            <table class="table table-striped table-hover mb-5">
                                <thead>
                                    <tr>
                                        <th>Business Giver</th>
                                        {{-- <th>Login Member</th> --}}
                                        <th>Date</th>
                                        <th>Amount</th>
                                        {{-- <th>Status</th> --}}
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($busGiver as $busGiverData)
                                        <tr>
                                            <td>{{ $busGiverData->businessGiver->firstName . ' ' . $busGiverData->businessGiver->lastName ?? '-' }}
                                            </td>
                                            {{-- <td>{{ $busGiverData->loginMember->firstName . ' ' .
                                        $busGiverData->loginMember->lastName ?? '-' }}</td> --}}
                                            <td>{{ \Carbon\Carbon::parse($busGiverData->date)->format('d-m-Y') ?? '-' }}
                                            </td>
                                            <td>{{ $busGiverData->amount ?? '-' }}</td>
                                            {{-- <td>{{ $busGiverData->status }}</td> --}}
                                            {{-- <td>
                                        <a href="{{ route('busGiver.edit', $busGiverData->id) }}"
                                            class="btn btn-bg-orange btn-sm btn-tooltip">
                                            <i class="bi bi-plus"></i>
                                            <span class="btn-text">Add Business Amount</span>
                                        </a>
                                    </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end custom-pagination">
                                {!! $busGiver->links() !!}
                            </div>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- business give by other --}}

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <h4 class="card-title">Business Slip Given</h4>
                            {{-- <a href="{{ route('busGiver.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a> --}}
                        </div>
                        <hr class="mb-5">
                        <!-- Table with stripped rows -->
                        <div class="table-responsive mt-5">
                            <table class="table table-striped table-hover mb-5">
                                <thead>
                                    <tr>
                                        <th>Member Name</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($busGiveByOther as $busGiveByOtherData)
                                        <tr>
                                            <td>{{ $busGiveByOtherData->loginMember->firstName . ' ' . $busGiveByOtherData->loginMember->lastName ?? '-' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($busGiveByOtherData->date)->format('d-m-Y') ?? '-' }}
                                            </td>
                                            <td>{{ $busGiveByOtherData->amount ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end" style="color: #1d3268">
                                {!! $busGiveByOther->links() !!}
                            </div>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
