@extends('layouts.master')

@section('title', 'UBN - Specific Ask')
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
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="card-title">Create Specific Ask</h4>
                <a href="{{ route('specificask.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>
            <hr class="mb-5">
            <form class="m-3 needs-validation" id="specificaskForm" enctype="multipart/form-data" method="post"
                action="{{ route('specificask.store') }}" novalidate>
                @csrf
                <div class="row mb-3 ">
                    <div class="col-md-12">
                        <div class="form-floating mt-3">
                            <textarea class="form-control @error('ask') is-invalid @enderror" id="ask" name="ask" placeholder="Enter ask"></textarea>
                            <label for="ask">Add Your Specific Ask</label>
                            @error('ask')
                                <div class="invalid-tooltip">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                </div>
            </form><!-- End floating Labels Form -->
        </div>
    </div>



@endsection
