@extends('layouts.master')

@section('title', 'UBN - Create Support Ticket')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Create Ticket</h4>
            <a href="{{ route('support.myIndex') }}" class="btn btn-bg-orange btn-sm">Back</a>
        </div>

        <div class="card-body px-4 py-3">
            <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-8">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}">
                        @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- <div class="col-md-4">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                            <option value="Low" {{ old('priority')=='Low' ?'selected':'' }}>Low</option>
                            <option value="Medium" {{ old('priority')=='Medium' ?'selected':'' }}>Medium</option>
                            <option value="High" {{ old('priority')=='High' ?'selected':'' }}>High</option>
                        </select>
                        @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> --}}

                    <div class="col-md-8">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Attachment</label>
                        <input type="file" name="attachment"
                            class="form-control @error('attachment') is-invalid @enderror">
                        @error('attachment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
