@role('Admin')
    @extends('layouts.master')

    @section('header', 'Event')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Registraion List of {{ $event->title }} </h4>

                    <a href="{{ route('event.index') }}" class="btn btn-bg-orange btn-sm">BACK</a>

                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                {{-- <th>S.No</th> --}}
                                {{-- <th>Event Name</th> --}}
                                <th>Member Name</th>
                                <th>Visitor Name</th>
                                <th>Business Category</th>
                                <th>Business Name</th>
                                {{-- <th>Person Email</th> --}}

                                <th>Visitor Contact</th>
                                <th>Reference By</th>
                                {{-- <th>Action</th> --}}
                                <th>Payment Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registerLists as $registerListsData)
                                <tr>
                                    {{-- <th>{{ ($registerLists->currentPage() - 1) * $registerLists->perPage() + $loop->index + 1 }} --}}

                                    {{-- <td>{{ $registerListsData->events->title ?? '-' }}</td> --}}
                                    <td>{{ $registerListsData->members->firstName ?? '-' }}
                                        {{ $registerListsData->members->lastName ?? '-' }}
                                    </td>
                                    <td>{{ $registerListsData->personName ?? '-' }}</td>
                                    <td>{{ $registerListsData->members->bCategory->categoryName ?? '-' }}</td>
                                    <td>{{ $registerListsData->businessName ?? '-' }}</td>

                                    <td>{{ $registerListsData->personContact ?? '-' }}</td>

                                    {{-- <td>{{ $registerListsData->visitors->firstName ?? '' }} {{ $registerListsData->visitors->lastName ?? '' }}</td> --}}
                                    {{-- <td></td> --}}
                                    {{-- <td>{{ $registerListsData->visitors->mobileNo ?? '' }}</td> --}}
                                    {{-- <td>{{ $registerListsData->refMembers->firstName ?? '' }}
                                        {{ $registerListsData->refMembers->lastName ?? '' }} </td>
                                    <td> --}}

                                    <td>{{ $registerListesData->refMemberId ?? '-' }}</td>

                                    <td>
                                        <select class="form-select payment-status-dropdown" data-id="{{ $registerListsData->id }}">
                                            <option value="Paid" {{ $registerListsData->PaymentStatus == 'Paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="Unpaid" {{ $registerListsData->PaymentStatus == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        </select>
                                    </td>


                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $registerList->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            $('.payment-status-dropdown').change(function() {
                const registerId = $(this).data('id');
                const paymentStatus = $(this).val();

                if (registerId) {
                    $.ajax({
                        url: '{{ route('updatePaymentStatus') }}', // Define the route in your web.php
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}', // Include CSRF token for security
                            id: registerId,
                            paymentStatus: paymentStatus,
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Payment status updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update payment status.',
                                    icon: 'error',
                                    confirmButtonText: 'Try Again'
                                });
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr);
                            Swal.fire({
                                title: 'Oops!',
                                text: 'An error occurred while updating payment status.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    </script>

@endrole
@endsection
