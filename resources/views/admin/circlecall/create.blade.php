@extends('layouts.master')

@section('header', 'Circle 1:1 Meeting')
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
            <h5 class="card-title">Create 1:1 Meeting</h5>
            <a href="{{ route('circlecall.index') }}" class="btn btn-secondary btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="circlecallForm" enctype="multipart/form-data" method="post" action="{{ route('circlecall.store') }}" novalidate>
            @csrf

            <div class="col-md-12">
                {{-- <input type="text" name="memberName" id="memberName" placeholder="Search member Name" class="form-control"> --}}
                <label for="search" class="form-labelv fw-bold">Search member</label>
                <select class="form-select" id="search">
                </select>

            </div>

            <br>
            {{-- circlememberId stor baki --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="hidden" id="selectedMemberId" name="meetingPersonId">

                        <!-- Searchable input field -->
                        <input type="text" class="form-control" readonly id="memberName" placeholder="Select Member">
                        <label for="memberName">Meeting Person Name</label>
                        @error('memberId')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('meetingPlace') is-invalid @enderror" id="meetingPlace" name="meetingPlace" placeholder="Meeeting Place Name" required>
                        <label for="meetingPlace">Meeting Place Name</label>
                        @error('meetingPlace')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" placeholder="Meeeting Place Name" required>
                        <label for="date">Date</label>
                        @error('date')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mt-3">
                        <input type="text" class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" placeholder="Remarks" required>
                        <label for="remarks">Remarks</label>
                        @error('remarks')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>


    {{-- script section --}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <script type="text/javascript">
        var path = "{{ route('getMember') }}";

        $('#search').select2({
            placeholder: 'Select Member',
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.firstName,
                                id: item.id,
                                firstName: item.firstName // Adding firstName attribute to the option data
                            }
                        })
                    };
                },
                cache: true
            }
        });

        // Update the hidden input field with the selected member's ID
        $('#search').on('select2:select', function(e) {
            var data = e.params.data;
            $('#selectedMemberId').val(data.id);
            $('#memberName').val(data.firstName);
        });
    </script>
@endsection
