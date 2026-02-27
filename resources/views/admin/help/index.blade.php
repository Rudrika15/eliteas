@extends('layouts.master')

@section('header', 'Help')
@section('content')

    {{-- Message --}}
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Resources</h4>
                    <a href="{{ route('help.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Resources</span></a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Resource Category</th>
                                <th>Title</th>
                                <th>Photo</th>
                                <th>PDF</th>
                                <th>Video</th>
                                <th>Description</th>
                                {{-- <th>Status</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($help as $helpData)
                                <tr>
                                    <th>{{ ($help->currentPage() - 1) * $help->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $helpData->resourceCategory->categoryName ?? '' }}</td>
                                    <td>{{ $helpData->title ?? '' }}</td>
                                    <td>
                                        @if ($helpData->photo)
                                            <img src="{{ asset('help/' . $helpData->photo) }}" alt="Photo Preview" width="100" height="100" style="object-fit: cover;">
                                        @else
                                            <span>No photo available</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($helpData->pdf)
                                            <a href="{{ asset('help/' . $helpData->pdf) }}" target="_blank">View PDF</a>
                                        @else
                                            <span>No PDF available</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($helpData->video)
                                            <video width="100" height="100" controls>
                                                <source src="{{ asset('help/' . $helpData->video) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <span>No video available</span>
                                        @endif
                                    </td>
                                    <td>{{ $helpData->description ?? '' }}</td>
                                    {{-- <td>{{ $helpData->status }}</td> --}}
                                    <td>
                                        <a href="{{ route('help.edit', $helpData->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <a href="{{ route('help.delete', $helpData->id) }}" class="btn btn-danger btn-sm btn-tooltip">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $help->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
