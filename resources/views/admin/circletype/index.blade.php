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

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Circle Type</h4>
                <a href="{{ route('circletype.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                        class="bi bi-plus-circle"></i></a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table datatable table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Circle Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($circletype as $circleData)
                        <tr>
                            <td>{{$circleData->circleTypeName}}</td>
                            <td>{{$circleData->status}}</td>
                            <td>
                                <a href="{{ route('circletype.edit', $circleData->id) }}"
                                    class="btn btn-bg-blue btn-sm">
                                    <i class="bi bi-pen"></i>
                                </a>

                                {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                <a href="{{ route('circletype.delete', $circleData->id) }}"
                                    class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </a>

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
        </div>
    </div>
</div>
@endsection