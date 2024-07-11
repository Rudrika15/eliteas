@extends('layouts.master')

@section('header', 'Trainer Master')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">Trainer Master</h4>
            <a href="{{ route('trainer.create') }}" class="btn btn-bg-orange btn-sm mt-3"><i
                    class="bi bi-plus-circle"></i></a>
        </div>

        <!-- Table with stripped rows -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                        <td>{{$trainerData->users->contactNo ?? $trainerData->externalMemberContact ?? '-'}} </td>
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
            <div class="d-flex justify-content-end" style="color: #1d3268">
                {!! $trainer->links() !!}
            </div>
        </div>
    </div>
</div>
<!-- End Table with stripped rows -->
@endsection