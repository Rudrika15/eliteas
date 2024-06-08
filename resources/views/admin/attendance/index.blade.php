@extends('layouts.master')

@section('header', 'City')
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
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Take Attendance of Circle Members</h5>
        <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
    </div>
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <table class="table datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Name</th>
                    <th width="5%"><input type="checkbox" id="checkAll"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($circleMembers as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->firstName }} {{ $member->lastName }}</td>
                    <td><input type="checkbox" name="memberId[]" value="{{ $member->id }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center mb-3">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form>
</div>
</div>



<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Take Attendance of Invited Peoples</h5>
    </div>
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <table class="table datatable">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Name</th>
                    <th width="5%"><input type="checkbox" id="checkAll"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($meetingInvitations as $meetingInvitationsData)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $meetingInvitationsData->personName }}</td>
                    <td><input type="checkbox" name="meetingId[]" value="{{ $meetingInvitationsData->id }}"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center mb-3">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#checkAll').click(function() {
            $('input:checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>
@endsection