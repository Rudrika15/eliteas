@extends('layouts.master')

@section('header', 'Trainer Master')
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
            <h4 class="mb-0 mt-3">Trainer Master</h4>
            <a href="{{ route('trainer.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i class="bi bi-plus-circle"></i></a>
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Trainer Name</th>
                    <th>Type</th>
                    <th>Contact No</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainer as $trainerData)
                <tr>
                    <td>{{$trainerData->user->firstName}} {{$trainerData->user->lastName}}</td>
                    <td>@if($trainerData->type == 'internalMember')
                        Internal Member
                    @elseif($trainerData->type == 'externalMember')
                        External Trainer
                    @endif
                    </td>
                    <td>{{$trainerData->user->ContactNo ?? '-'}}</td>
                    <td>{{$trainerData->status}}</td>

                    <td>
                        {{-- <a href="{{ route('trainer.edit', $trainerData->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a> --}}
            
                        <a href="{{ route('trainer.delete', $trainerData->id) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
            
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection