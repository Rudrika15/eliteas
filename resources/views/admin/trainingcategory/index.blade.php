@extends('layouts.master')

@section('header', 'Training Category')
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
                    <h4 class="card-title">Training Category</h4>
                    <a href="{{ route('tCategory.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Training Category</span>
                    </a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trainingCategory as $trainingCategoryData)
                                <tr>
                                    <th>{{ ($trainingCategory->currentPage() - 1) * $trainingCategory->perPage() + $loop->index + 1 }}
                                    <td>{{ $trainingCategoryData->categoryName ?? '-' }}</td>

                                    <td>{{ $trainingCategoryData->status }}</td>
                                    <td>
                                        <a href="{{ route('tCategory.edit', $trainingCategoryData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                        <a href="{{ route('tCategory.delete', $trainingCategoryData->id) }}"
                                            class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $trainingCategory->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
