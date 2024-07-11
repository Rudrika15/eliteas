@extends('layouts.master')

@section('header', 'Trainer List')
@section('content')

{{-- Message --}}
{{-- @if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Error !</strong> {{ session('error') }}
</div>
@endif --}}

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Trainer List</h4>
            <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm">Back
                {{-- <i class="bi bi-file-earmark-excel"></i> <!-- Bootstrap Icon for Excel File --> --}}
            </a>
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Training Name</th>
                        <th>Date</th>
                        <th>Trainer Name</th>
                        {{-- <th>Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trainers as $trainerData)
                    <tr>
                        <td>{{$trainerData->training->title ?? '-'}}</td>
                        <td>{{ \Carbon\Carbon::parse($trainerData->training->date)->format('d-m-y') ?? '-'}}</td>

                        <td>{{$trainerData->user->firstName ?? '-'}} {{$trainerData->user->lastName ?? '-'}}</td>
                        {{-- <td>{{$trainerData->status}}</td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $trainers->links() !!}
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>
</div>
@endsection