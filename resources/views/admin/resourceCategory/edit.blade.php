@extends('layouts.master')

@section('header', 'Resource Categories')
@section('content')
    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Edit Resource Category</h5>
            <a href="{{ route('resourceCategory.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <form class="m-3 needs-validation" method="post" action="{{ route('resourceCategory.update') }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $category->id ?? '' }}">

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('categoryName') is-invalid @enderror" id="categoryName" name="categoryName" placeholder="Category Name" value="{{ old('categoryName', $category->categoryName ?? '') }}" required>
                        <label for="categoryName">Category Name</label>
                        @error('categoryName')
                            <div class="invalid-tooltip">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form>
    </div>
@endsection
