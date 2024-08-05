@extends('layouts.master')

@section('header', 'Visitors')
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
                <h4 class="card-title">Visitors</h4>
                {{-- <a href="{{ route('country.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                        class="bi bi-plus-circle"></i>
                    <span class="btn-text">Add Country</span></a> --}}
            </div>

            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Business Name</th>
                            <th>Business Category</th>
                            <th>Networking Group</th>
                            <th>Circle Meet</th>
                            <th>Product / Service</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitors as $index => $visitor)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{$visitor->firstName}} {{$visitor->lastName}}</td>
                            <td>{{$visitor->mobileNo}}</td>
                            <td>{{$visitor->businessName}}</td>
                            <td>{{$visitor->businessCategory}}</td>
                            <td>{{$visitor->networkingGroup}}</td>
                            <td>{{$visitor->circleMeet}}</td>
                            <td>{{$visitor->product}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $visitors->links() !!}
                </div>
                <!-- End Table with stripped rows -->
            </div>
        </div>
    </div>
</div>
@endsection