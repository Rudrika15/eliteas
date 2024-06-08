@extends('layouts.master')

@section('header', 'Trainer List')
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
            <h4 class="card-title">Trainer List</h4>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Training Name</th>
                    <th>Trainer Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainers as $trainerData)
                <tr>
                    <td>{{$trainerData->training->title ?? '-'}}</td>
                    <td>{{$trainerData->user->firstName ?? '-'}} {{$trainerData->user->lastName ?? '-'}}</td>
                    <td>{{$trainerData->status}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection