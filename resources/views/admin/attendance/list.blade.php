@extends('layouts.master')

@section('header', 'List')
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
        <h4 class="mb-0 mt-3">List of Attended Members</h4>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendedMembers as $attendedMembersData)
                    <tr>
                        <td>{{ $attendedMembersData->firstName }} {{ $attendedMembersData->lastName }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
                <button type="reset" class="btn btn-bg-orange">Reset</button>
            </div>
        </form>
    </div>
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