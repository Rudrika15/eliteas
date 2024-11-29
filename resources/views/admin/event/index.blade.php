@extends('layouts.master')

@section('header', 'Event')
@section('content')


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Events</h4>
                    <a href="{{ route('event.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Create Event</span></a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Circle</th>
                                <th>Event Date</th>
                                <th>Slot Date</th>
                                <th>Event Image</th>
                                <th>Event Banner</th>
                                <th>Venue</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Fees</th>
                                <th>QR Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event as $eventData)
                                <tr>
                                    {{-- <td>{{ $loop->index + 1 }}</td> --}}
                                    <th>{{ ($event->currentPage() - 1) * $event->perPage() + $loop->index + 1 }}

                                    <td>{{ $eventData->title ?? '-' }}</td>
                                    <td>{{ $eventData->circle->circleName ?? '-' }}</td>
                                    <td>{{ $eventData->event_date }}</td>
                                    <td>{{ $eventData->slot_date }}</td>
                                    <td>
                                        @if ($eventData->event_thumb)
                                            <img src="{{ url('Event/' . basename($eventData->event_thumb)) }}"
                                                alt="Event Image"
                                                style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                        @else
                                            <span></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($eventData->event_banner)
                                            <img src="{{ url('Event/' . basename($eventData->event_banner)) }}"
                                                alt="Event Banner"
                                                style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                        @else
                                            <span></span>
                                        @endif
                                    </td>
                                    <td>{{ $eventData->venue }}</td>
                                    <td>{{ $eventData->start_time }}</td>
                                    <td>{{ $eventData->end_time }}</td>
                                    <td>{{ $eventData->fees }}</td>
                                    <td>
                                        @if ($eventData->qr_code)
                                            <a href="javascript:void(0);" onclick="showImage('{{ url('eventQR/' . basename($eventData->qr_code)) }}')">
                                                <img src="{{ url('eventQR/' . basename($eventData->qr_code)) }}" alt="Event QR Code"
                                                    style="width: 50px; height: 50px; object-fit: contain; aspect-ratio: 1/1;">
                                            </a>
                                        @else
                                            <span>No QR Code Found</span>
                                        @endif
                                    </td>

                                    <!-- Modal for displaying the QR code -->
                                    <div id="qrModal" style="display: none;">
                                        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; text-align: center;">
                                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 10px;">
                                                <img id="qrImage" src="" alt="QR Code" style="max-width: 100%; max-height: 80vh; object-fit: contain;">
                                                <div style="margin-top: 10px; text-align: center;">
                                                    <button class="btn btn-success mr-2" onclick="downloadQRCode('png')">Download</button>
                                                    <button class="btn btn-primary mr-2" onclick="printQRCode()">Print</button>
                                                    <button class="btn btn-danger" onclick="closeModal()">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function downloadQRCode(type) {
                                            var img = document.getElementById("qrImage");
                                            var link = document.createElement('a');
                                            link.href = img.src;
                                            link.download = "qrCode." + type;
                                            link.click();
                                        }
                                    </script>
                                    <td>
                                        <a href="{{ route('slotbooking.list', $eventData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-list"></i>
                                            <span class="btn-text">Slot Booking Details</span>
                                        </a>

                                        <a href="{{ route('event.eventRegisterList', $eventData->id) }}"
                                            class="btn btn-bg-orange btn-sm btn-tooltip">
                                            <i class="bi bi-eye"></i>
                                            <span class="btn-text">List of Registred User</span>
                                        </a>

                                        <a href="{{ route('event.edit', $eventData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>



                                        <a href="javascript:void(0);" data-url="{{ route('event.delete', $eventData->id) }}"
                                            class="btn btn-danger btn-sm btn-tooltip delete-button">
                                            <i class="bi bi-trash"></i>
                                            <span class="btn-text">Delete</span>
                                        </a>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                document.body.addEventListener('click', function(event) {
                                                    if (event.target.closest('.delete-button')) {
                                                        event.preventDefault();

                                                        const deleteButton = event.target.closest('.delete-button');
                                                        const deleteUrl = deleteButton.dataset.url;

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
                                                                // Perform delete using AJAX
                                                                fetch(deleteUrl, {
                                                                    method: 'DELETE',
                                                                    headers: {
                                                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                                                    }
                                                                })
                                                                    .then(response => response.json())
                                                                    .then(data => {
                                                                        if (data.success) {
                                                                            Swal.fire({
                                                                                icon: 'success',
                                                                                title: 'Deleted!',
                                                                                text: 'Event has been deleted.'
                                                                            }).then((result) => {
                                                                                if (result.isConfirmed) {
                                                                                    window.location.reload();
                                                                                }
                                                                            });
                                                                        } else {
                                                                            Swal.fire({
                                                                                icon: 'error',
                                                                                title: 'Oops...',
                                                                                text: 'Something went wrong!'
                                                                            });
                                                                        }
                                                                    })
                                                                    .catch(error => {
                                                                        console.error('Error deleting event:', error);
                                                                        Swal.fire({
                                                                            icon: 'error',
                                                                            title: 'Oops...',
                                                                            text: 'Something went wrong!'
                                                                        });
                                                                    });
                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        </script>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $event->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show the modal with the image
        function showImage(imageUrl) {
            document.getElementById('qrImage').src = imageUrl;
            document.getElementById('qrModal').style.display = 'block';
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('qrModal').style.display = 'none';
        }

        // Function to download the QR code
        function downloadQRCode() {
            var imageUrl = document.getElementById('qrImage').src;
            var a = document.createElement('a');
            a.href = imageUrl;
            a.download = 'event-qr-code.png'; // You can customize the filename here
            a.click();
        }

        // Function to print the QR code
        function printQRCode() {
            var printWindow = window.open('', '', 'width=800,height=600');
            var img = document.getElementById('qrImage');
            printWindow.document.write('<html><body><img src="' + img.src + '" style="width:100%;"></body></html>');
            printWindow.document.close();
            printWindow.print();
        }

            </script>


@endsection
