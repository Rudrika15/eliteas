@extends('layouts.master')

@section('header', 'Resource Categories')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Resource Categories</h4>
                    <a href="{{ route('resourceCategory.create') }}" class="btn btn-bg-orange btn-sm mt-2 btn-tooltip">
                        <i class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add Category</span>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <th>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $category->categoryName ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('resourceCategory.edit', $category->id) }}" class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        <a href="{{ route('resourceCategory.delete', $category->id) }}" class="btn btn-danger btn-sm btn-tooltip" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No categories found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end custom-pagination">
                    {!! $categories->links() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '.delete-confirm', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    </script>
@endsection
