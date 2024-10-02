@extends('layouts.master')

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
                <h2 class="mt-3 card-title">Users Management</h2>
                <a class="btn btn-bg-blue mt-3 btn-sm btn-tooltip" href="{{ route('export.users') }}">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                    <span class="btn-text">Export to Excel</span>
                </a>
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->firstName ?? '' }}</td>
                                <td>{{ $user->lastName ?? '' }}</td>
                                <td>{{ $user->email ?? '' }}</td>
                                <td>{{ $user->contactNo ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $data->links() !!}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>
@endsection
