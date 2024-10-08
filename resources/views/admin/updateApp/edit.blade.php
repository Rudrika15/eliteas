@extends('layouts.master')

@section('header', 'Update App')
@section('content')


    <div class="card">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h5 class="card-title">Update App Version</h5>
            <a href="{{ route('home') }}" class="btn btn-bg-orange btn-sm">BACK</a>
        </div>

        <!-- Floating Labels Form -->
        <form class="m-3 needs-validation" id="stateForm" enctype="multipart/form-data" method="post"
            action="{{ route('updateApp.update', $updateApp->id) }}" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ $updateApp->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-control" name="major" id="major">
                            <option value="" selected disabled> Is Major Update ? </option>
                            <option value="true" {{ old('major', $updateApp->major) == 'true' ? 'selected' : '' }}>True
                            </option>
                            <option value="false" {{ old('major', $updateApp->major) == 'false' ? 'selected' : '' }}>False
                            </option>
                        </select>
                        <label for="major">Is Major Update ?</label>
                        @error('major')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="text" class="form-control @error('version') is-invalid @enderror" id="version"
                            name="version" value="{{ $updateApp->version }}" placeholder="State Name" required>
                        <label for="version">App Version</label>
                        @error('version')
                            <div class="invalid-tooltip">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-bg-blue">Submit</button>
            </div>
        </form><!-- End floating Labels Form -->
    </div>


    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

@endsection
