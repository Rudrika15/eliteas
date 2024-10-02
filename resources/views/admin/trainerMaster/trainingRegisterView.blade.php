@extends('layouts.master')

@section('header', 'Trainer Master')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Registred Member List for Training</h4>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Training Title</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainingRegister as $trainingRegisterData)
                            <tr>
                                <td>{{ $trainingRegisterData->user->firstName ?? '' }}
                                    {{ $trainingRegisterData->user->lastName ?? '' }}</td>

                                <td>{{ $trainingRegisterData->training->title ?? '' }} </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $trainingRegister->links() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- End Table with stripped rows -->
@endsection
