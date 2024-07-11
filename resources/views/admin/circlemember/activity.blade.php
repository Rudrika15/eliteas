@extends('layouts.master')

@section('header', 'Circle 1:1')
@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #dddddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .table-title {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }
</style>

<script>
    function previewPhoto(event) {
        const photo = document.getElementById('photoPreview');
        photo.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

<title>User Activity</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .activity-card {
        margin-bottom: 20px;
        border: 1px solid #dddddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
    }

    .activity-card-header {
        background-color: #f2f2f2;
        padding: 10px;
        font-weight: bold;
    }

    .activity-table {
        width: 100%;
        border-collapse: collapse;
    }

    .activity-table th,
    .activity-table td {
        padding: 10px;
        border-bottom: 1px solid #dddddd;
        text-align: left;
    }

    .activity-table th {
        background-color: #f2f2f2;
    }

    @media screen and (max-width: 600px) {
        .container {
            padding: 10px;
        }
    }
</style>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title">1:1 Meeting</h4>
        </div>
        <hr class="mb-3">
        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table datatable mb-3">
                <thead>
                    <tr>
                        <th>Circle Member</th>
                        <th>Meeting Person</th>
                        <th>Meeting Place</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
               <tbody>
                @foreach ($circlecall as $circlecallData)
                <tr>
                    <td>{{ $circlecallData->member->firstName ?? '-' }}</td>
                    <td>{{ $circlecallData->meetingPerson->firstName ?? '-' }}
                        {{ $circlecallData->meetingPerson->lastName ?? '-' }}</td>
                    <td>{{ $circlecallData->meetingPlace ?? '-' }}</td>
                    <td>{{ $circlecallData->remarks ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        <!-- End Responsive Table -->
    </div>
</div>

<!-- Add another card for another table -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title-0 mt-2 text-blue">Reference Giver</h4>
        </div>
        <hr class="mb-3">
        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table datatable mb-3">
                <thead>
                    <tr>
                        <th>Member Name</th>
                        {{-- <th>Reference Giver Name</th> --}}
                        <th>Contact Name</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Scale</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($refGiver as $refGiverData)
                    <tr>
                        <td>{{ $refGiverData->members->firstName ?? '-' }}
                            {{ $refGiverData->members->lastName ?? '-' }}
                        </td>
                        {{-- <td>{{ $refGiverData->refGiverName->firstName ?? '-' }}</td> --}}
                        <td>{{ $refGiverData->contactName ?? '-' }}</td>
                        <td>{{ $refGiverData->contactNo ?? '-' }}</td>
                        <td>{{ $refGiverData->email ?? '-' }}</td>
                        <td>{{ $refGiverData->scale ?? '-' }}</td>
                        <td>{{ $refGiverData->description ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Responsive Table -->
    </div>
</div>

<!-- Add another card for another table -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title-0 mt-2 text-blue">Business Giver</h4>
        </div>
        <hr class="mb-3">
        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table datatable mb-3">
                <thead>
                    <tr>
                        <th>Business Giver</th>
                        {{-- <th>Login Member</th> --}}
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($busGiver as $busGiverData)
                    <tr>
                        {{-- <td>{{ $busGiverData->businessGiver->firstName . ' ' . $busGiverData->businessGiver->lastName ?? '-' }}
                        </td> --}}
                        <td>{{ $busGiverData->businessGiver->firstName ?? '-' }} {{$busGiverData->businessGiver->lastName ?? '-' }}
                        </td>
                        {{-- <td>{{ $busGiverData->loginMember->firstName . ' ' . $busGiverData->loginMember->lastName ?? '-' }}</td>
                        --}}
                        <td>{{ $busGiverData->amount ?? '-' }}</td>
                        <td>{{ $busGiverData->date ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Responsive Table -->
    </div>
</div>

<!-- Add another card for another table -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title-0 mt-2 text-blue">Testimonial</h4>
        </div>
        <hr class="mb-3">
        <!-- Responsive Table -->
        <div class="table-responsive">
            <table class="table datatable mb-3">
                <thead>
                    <tr>
                        <th>Testimonial Giver</th>
                        <th>Testimonial Taker</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonials as $testimonialData)
                    <tr>
                        <td>{{ $testimonialData->user->firstName ?? '-' }}
                            {{ $testimonialData->user->lastName ?? '-' }}
                        </td>
                        <td>{{ $testimonialData->member->firstName ?? '-' }}
                            {{ $testimonialData->member->lastName ?? '-' }}</td>
                        <td>{{ $testimonialData->message }}</td>
                        <td>{{ $testimonialData->uploadedDate }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End Responsive Table -->
    </div>
</div>

<!-- Add more cards and tables as needed -->


@endsection