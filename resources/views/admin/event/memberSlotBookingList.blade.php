@extends('layouts.master')

@section('header', 'Event')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Event Slot Booking List</h4>
                    {{-- <a href="{{ route('event.index') }}" class="btn btn-bg-orange btn-sm">BACK</a> --}}
                </div>



                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Slot Time</th>
                                <th>Booked By</th>
                                {{-- <th>Visitor Name</th> --}}
                                {{-- <th>Booked By</th> --}}
                                <th>Date</th>
                                <th>Booking Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($event->slot_date == null)
                                <tr>
                                    <td colspan="7" class="text-center">Slot Booking is not available for this event</td>
                                </tr>
                            @elseif ($slotBooking->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">No data available</td>
                                </tr>
                            @endif

                            @foreach ($slotBooking as $slotBookingData)
                                <tr>
                                    <th>{{ ($slotBooking->currentPage() - 1) * $slotBooking->perPage() + $loop->index + 1 }}</th>
                                    <td>{{ $slotBookingData->slots->start_time ?? '' }} - {{ $slotBookingData->slots->end_time ?? '' }}</td>
                                    <td>{{ $slotBookingData->users->firstName ?? '' }} {{ $slotBookingData->users->lastName ?? '' }} {{ $slotBookingData->visitors->firstName ?? '' }} {{ $slotBookingData->visitors->lastName ?? '' }}</td>
                                    {{-- <td>{{ $slotBookingData->visitors->firstName ?? '' }} {{ $slotBookingData->visitors->lastName ?? '' }}</td> --}}
                                    {{-- <td>{{ $slotBookingData->refMembers->firstName ?? '' }} {{ $slotBookingData->refMembers->lastName ?? '' }}</td> --}}
                                    <td>{{ \Carbon\Carbon::parse($slotBookingData->date)->format('d-m-Y') ?? '' }}</td>
                                    <td>
                                        <form action="{{ route('slotBooking.updateStatus', $slotBookingData->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="bookingStatus" class="form-select" onchange="this.form.submit()"
                                                    style="background-color:
                                                        {{ $slotBookingData->bookingStatus == 'Pending' ? '#ffc107' :
                                                        ($slotBookingData->bookingStatus == 'Approved' ? '#28a745' : '#dc3545') }};
                                                        color: white; font-weight: bold;">
                                                <option value="Pending" style="background-color: #ffc107; color: white;"
                                                    {{ $slotBookingData->bookingStatus == 'Pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="Approved" style="background-color: #28a745; color: white;"
                                                    {{ $slotBookingData->bookingStatus == 'Approved' ? 'selected' : '' }}>
                                                    Approved
                                                </option>
                                                <option value="Rejected" style="background-color: #dc3545; color: white;"
                                                    {{ $slotBookingData->bookingStatus == 'Rejected' ? 'selected' : '' }}>
                                                    Rejected
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $slotBooking->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
