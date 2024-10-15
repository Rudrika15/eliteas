@extends('layouts.master')

@section('header', 'Error List')
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Error List <i class="bi bi-exclamation-triangle" style="color: red"></i> </h4>
                    <p style="color: red;">* You can Change the status by clicking on repected fields.</p>
                    {{-- <p>Note: It is only for Status Column</p> --}}
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">S.No</th>
                                <th class="text-center">Page URL</th>
                                <th class="text-center">Error Message</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($errorList as $key => $errorListData)
                                <tr>
                                    <th>{{ $key + $errorList->firstItem() }}</th>
                                    <td style="max-width: 500px">{{ $errorListData->url ?? '-' }}</td>
                                    <td>{{ $errorListData->error_message ?? '-' }}</td>
                                    <td>{{ $errorListData->date ?? '-' }}</td>
                                    <td>{{ $errorListData->time ?? '-' }}</td>
                                    <td style="width: 110px;">
                                        <select class="form-control update-status" data-id="{{ $errorListData->id }}">
                                            <option value="Pending"
                                                {{ $errorListData->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Working"
                                                {{ $errorListData->status == 'Working' ? 'selected' : '' }}>Working</option>
                                            <option value="Resolved"
                                                {{ $errorListData->status == 'Resolved' ? 'selected' : '' }}>Resolved
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $errorList->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->

    <!-- Add the CSS styles for the background colors -->
    <style>
        .pending {
            background-color: #f4e04d;
            /* Yellow for Pending */
            color: black;
        }

        .working {
            background-color: #f5a623;
            /* Orange for Working */
            color: black;
        }

        .resolved {
            background-color: #4caf50;
            /* Green for Resolved */
            color: white;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElements = document.querySelectorAll('.update-status');

            // Function to update the background color based on the status
            function updateSelectColor(selectElement) {
                const status = selectElement.value;

                // Remove any previously applied classes
                selectElement.classList.remove('pending', 'working', 'resolved');

                // Add the appropriate class based on the selected status
                if (status === 'Pending') {
                    selectElement.classList.add('pending');
                } else if (status === 'Working') {
                    selectElement.classList.add('working');
                } else if (status === 'Resolved') {
                    selectElement.classList.add('resolved');
                }
            }

            // Apply the correct color when the page loads
            selectElements.forEach(function(selectElement) {
                updateSelectColor(selectElement);

                // Update the color dynamically when the status changes
                selectElement.addEventListener('change', function() {
                    let errorId = this.getAttribute('data-id');
                    let newStatus = this.value;

                    // Update the color on change
                    updateSelectColor(selectElement);

                    // Send an AJAX request to update the status
                    fetch(`/update-error-status/${errorId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Success Alert using SweetAlert
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Status updated successfully',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                // Error Alert using SweetAlert
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update status',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            // General Error Alert using SweetAlert
                            Swal.fire({
                                title: 'Error!',
                                text: 'Error updating status',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        });
                });
            });
        });
    </script>

@endsection
