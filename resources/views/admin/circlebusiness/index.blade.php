@extends('layouts.master')

@section('header', 'Reference Giver')
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 mt-3">Circle Meeting Member Business</h4>
            <a href="{{ route('busGiver.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Business Giver</th>
                    <th>Login Member</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($busGiver as $busGiverData)
                <tr>
                    <td>{{$busGiverData->businessGiver ?? '-'}}</td>
                    <td>{{$busGiverData->loginMember ?? '-'}}</td>
                    <td>{{$busGiverData->amount ?? '-'}}</td>
                    <td>{{$busGiverData->date ?? '-'}}</td>
                    <td>{{$busGiverData->status}}</td>
                    <td>
                        <a href="{{ route('busGiver.edit', $busGiverData->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a>

                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                        </a> --}}

                        <form action="{{ route('busGiver.delete', $busGiverData->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> <!-- Icon for delete -->
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection