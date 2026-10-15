@extends('layouts.master')

@section('title', 'UBN - Testimonial')
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
                <h4 class="card-title">Testmonial</h4>
                <a href="{{ route('testimonials.indexAdmin') }}" class="btn btn-bg-orange btn-sm mt-3">Back</a>
            </div>

            <!-- Table with stripped rows -->
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Testimonial Giver</th>
                        <th>Testimonial Taker</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonials as $testimonialData)
                        <tr>
                            <td>{{ ($testimonials->currentPage() - 1) * $testimonials->perPage() + $loop->index + 1 }}
                            <td>{{ $testimonialData->user->firstName ?? '-' }} {{ $testimonialData->user->lastName ?? '-' }}
                            </td>
                            <td>{{ $testimonialData->member->firstName ?? '-' }}
                                {{ $testimonialData->member->lastName ?? '-' }}</td>
                            <td>{{ $testimonialData->message }}</td>
                            <td>{{ $testimonialData->uploadedDate }}</td>
                            <td>{{ $testimonialData->status }}</td>
                            <td class="text-center">

                                <a href="{{ route('testimonial.restore', $testimonialData->id) }}"
                                    class="btn btn-success btn-sm justify-content-center align-items-center"
                                    onclick="event.preventDefault();restoreTestimonial(this);">Restore</a>
                                <script>
                                    function restoreTestimonial(element) {
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "Do you want to restore this testimonial?",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, restore it!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = element.href;
                                                Swal.fire(
                                                    'Restored!',
                                                    'Testimonial has been restored.',
                                                    'success'
                                                )
                                            }
                                        })
                                    }
                                </script>

                                <a href="{{ route('testimonial.delete', $testimonialData->id) }}"
                                    class="btn btn-danger btn-sm  justify-content-center align-items-center"
                                    onclick="event.preventDefault();deleteTestimonial(this);">Delete</a>
                                <script>
                                    function deleteTestimonial(element) {
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "Do you want to delete permanently this testimonial ?",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, delete it!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = element.href;
                                                Swal.fire(
                                                    'Deleted!',
                                                    'Testimonial has been Deleted Successfully.',
                                                    'success'
                                                )
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
                {!! $testimonials->links() !!}
            </div>
            <!-- End Table with stripped rows -->
        </div>
    @endsection
