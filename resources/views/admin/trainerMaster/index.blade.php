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
            {{-- <a href="{{ route('trainer.create') }}" class="btn btn-primary btn-sm mt-3">ADD</a> --}}
        </div>

        <!-- Table with stripped rows -->
        <table class="table datatable">
            <thead>
                <tr>
                    <th>Trainer Name</th>
                    <th>Training Name</th>
                    {{-- <th>Status</th> --}}
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($trainer as $trainerData)
                <tr>
                    <td>{{$trainerData->trainerName}}</td>
                    <td>{{$trainerData->title ?? '-'}}</td>
                    {{-- <td>{{$trainerData->status}}</td> --}}
                    <td>
                        {{-- <a href="{{ route('trainer.edit', $trainerData->id) }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-pen"></i>
                        </a> --}}

                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                            <i class="bi bi-eye"></i>
                        </a> --}}

                        {{-- <a href="{{ route('trainer.delete', $trainerData->id) }}" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a> --}}

                        {{-- <form action="{{ route('trainer.delete', $trainerData->id) }}" method="POST"
                            style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> <!-- Icon for delete -->
                            </button>
                        </form> --}}

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- End Table with stripped rows -->
    </div>
    @endsection