@extends('layouts.master')

@section('title', 'UBN - Circle Business')
@section('content')

    {{-- Message --}}
    @if (Session::has('success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
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
                <h4 class="mb-0 mt-3 text-blue">Circle Member Business</h4>
                {{-- <a href="{{ route('busGiver.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a> --}}
            </div>
            <hr class="mb-5">
            <!-- Table with stripped rows -->
            <table class="table datatable mb-5">
                <thead>
                    <tr>
                        <th>Business Giver</th>
                        {{-- <th>Login Member</th> --}}
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($busGiver as $busGiverData)
                        <tr>
                            <td>{{ $busGiverData->businessGiver->firstName . ' ' . $busGiverData->businessGiver->lastName ?? '-' }}
                            </td>
                            {{-- <td>{{ $busGiverData->loginMember->firstName . ' ' . $busGiverData->loginMember->lastName ?? '-' }}</td> --}}
                            <td>{{ $busGiverData->amount ?? '-' }}</td>
                            <td>{{ $busGiverData->date ?? '-' }}</td>
                            <td>{{ $busGiverData->status }}</td>
                            <td>
                                <a href="{{ route('busGiver.create', $busGiverData->id) }}" class="btn btn-bg-blue btn-sm">
                                    <i class="bi bi-plus"></i>
                                </a>
                                {{-- <a onclick="return confirm('Do You Want To Delete It')"
                                    href="{{ route('busGiver.delete', $busGiverData->id) }}"
                                    class="btn btn-bg-orange btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a> --}}

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Table with stripped rows -->
        </div>
    @endsection
