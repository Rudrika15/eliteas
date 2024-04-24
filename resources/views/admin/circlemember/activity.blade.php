@extends('layouts.master')

@section('header', 'Circle 1:1')
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


<div class="row dashboard-cards">
    <div class="card col-md-4">
        <a href="{{ route('circlecall.index') }}">
            <div class="card-title">
                <h4><small>Circle 1:1 Meetings</small></h4>
                {{-- <div class="task-count">14</div> --}}
            </div>
        </a>
    </div>

    <div class="card col-md-4">
        <div class="card-title">
            <a href="{{ route('circlecall.index') }}">
            <h4><small>Invited People for Circle Meetings</small></h4>
            {{-- <div class="task-count">14</div> --}}
        </div>
        </a>
    </div>

    <div class="card col-md-4">
        <div class="card-title">
            <a href="{{ route('circlecall.index') }}">
            <h4><small>Reference Giver Details</small></h4>
            {{-- <div class="task-count">14</div> --}}
        </div>
        </a>
    </div>

    <div class="card col-md-4">
        <div class="card-title">
            <h4><small>Circle Member Business</small></h4>
            {{-- <div class="task-count">14</div> --}}
        </div>
    </div>

    <div class="card col-md-4">
        <div class="card-title">
            <h3><small>Testimonials</small></h3>
            {{-- <div class="task-count">14</div> --}}
        </div>
    </div>

    <!-- Repeat similar structure for other cards (omitted for brevity) -->

</div>





@endsection