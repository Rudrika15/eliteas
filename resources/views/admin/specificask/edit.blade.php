@extends('layouts.master')

@section('header', 'City')
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
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Specific Ask</h5>
            <a href="{{ route('specificask.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="specificaskForm" enctype="multipart/form-data" method="post"
            action="{{ route('specificask.update', $specificasks->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $specificasks->id }}">
            <div class="row mb-3 ">

                <div class="col-md-12">
                    <div class="form-floating mt-3">
                        <textarea class="form-control @error('ask') is-invalid @enderror" id="ask" name="ask" placeholder="Enter ask">{{ $specificasks->ask }}</textarea>
                        <label for="ask">Add Your Specific Ask</label>
                        @error('ask')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>

@endsection
