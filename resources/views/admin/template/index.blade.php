@extends('layouts.master')

@section('title', 'UBN - Template')
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title">Template</h4>
                <a href="{{ route('template.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip">
                    <i class="bi bi-plus-circle"></i>
                    <span class="btn-text">Template</span>
                </a>
            </div>
            <hr class="mb-4">
            <!-- Table with stripped rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover mb-4">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Template Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($template as $templateData)
                            <tr>
                                {{-- <th>{{ ($template->currentPage() - 1) * $template->perPage() + $loop->index + 1 }}</th> --}}
                                <th>{{ $loop->iteration }}</th>
                                <td>
                                    @if ($templateData->templateImage)
                                        <img src="{{ url('templateImage/' . basename($templateData->templateImage)) }}"
                                            alt="Template Image" style="width: 100px; height: auto; border-radius: 5px;">
                                    @else
                                        <span></span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('template.edit', $templateData->id) }}"
                                        class="btn btn-bg-blue btn-sm btn-tooltip">
                                        <span class="btn-text">Edit Template</span>
                                        <i class="bi bi-pen"></i>
                                    </a>
                                    <button class="btn btn-danger btn-sm btn-tooltip"
                                        onclick="deleteRow('{{ route('template.delete', $templateData->id) }}')">
                                        <span class="btn-text">Delete</span>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <a href="{{ route('templateDetail.index', $templateData->id) }}"
                                        class="btn btn-bg-orange btn-sm btn-tooltip">
                                        <span class="btn-text">Template Details</span>
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                    <script>
                                        function deleteRow(url) {
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: "You won't be able to revert this!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#1d2856',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = url;
                                                }
                                            })
                                        }
                                    </script>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end custom-pagination">
                    {!! $template->links() !!}
                </div>
            </div>
            <!-- End Table with stripped rows -->
        </div>
    </div>

@endsection
