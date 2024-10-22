@extends('layouts.master')

@section('header', 'Visitors')
@section('content')


    <style>
        .remark-field {
            border: 1px solid #171212;
            padding: 5px;
            width: 100%;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Visitors</h4>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
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
                                <th>Invited By</th>
                                <th>Know about Us</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitors as $index => $visitor)
                                <tr>
                                    <td>{{ ($visitors->currentPage() - 1) * $visitors->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $visitor->firstName }} {{ $visitor->lastName }}</td>
                                    <td>{{ $visitor->mobileNo }}</td>
                                    <td>{{ $visitor->businessName }}</td>
                                    <td>{{ $visitor->bCategory->categoryName }}</td>
                                    <td>{{ $visitor->networkingGroup }}</td>
                                    <td>{{ $visitor->circleMeet }}</td>
                                    <td>{{ $visitor->product }}</td>
                                    <td>{{ $visitor->member->firstName ?? '' }} {{ $visitor->member->lastName ?? '' }}</td>
                                    <td>{{ $visitor->knowUs }}</td>
                                    <td>
                                        <input type="text" class="form-control remark-field" data-id="{{ $visitor->id }}"
                                            value="{{ $visitor->remarks }}">
                                    </td>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.remark-field').on('blur', function() {
                var visitorId = $(this).data('id');
                var newRemark = $(this).val();

                $.ajax({
                    url: '{{ route('visitor.updateRemark') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: visitorId,
                        remarks: newRemark
                    },

                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Remark updated successfully!',
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error updating remark!',
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
