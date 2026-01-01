@extends('layouts.master')

@section('title', 'UBN - Create Support Ticket')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit Ticket</h4>
            <a href="{{ route('support.myIndex') }}" class="btn btn-bg-orange btn-sm">Back</a>
        </div>

        <div class="card-body px-4 py-3">
            <form action="{{ route('support.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <div class="col-md-8">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject', $ticket->subject) }}">
                        @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- <div class="col-md-4">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select @error('priority') is-invalid @enderror">
                            <option value="Low" {{ old('priority',$ticket->priority)=='Low'?'selected':'' }}>Low
                            </option>
                            <option value="Medium" {{ old('priority',$ticket->priority)=='Medium'?'selected':''
                                }}>Medium</option>
                            <option value="High" {{ old('priority',$ticket->priority)=='High'?'selected':'' }}>High
                            </option>
                        </select>
                        @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div> --}}

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="Open" {{ old('status',$ticket->status)=='Open'?'selected':'' }}>Open</option>
                            <option value="In Progress" {{ old('status',$ticket->status)=='In Progress'?'selected':''
                                }}>In Progress</option>
                            <option value="Closed" {{ old('status',$ticket->status)=='Closed'?'selected':'' }}>Closed
                            </option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description',$ticket->description) }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Attachment</label>
                        <input type="file" name="attachment"
                            class="form-control @error('attachment') is-invalid @enderror">
                        @error('attachment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        @if($ticket->attachment)
                        <small class="d-block mt-2">
                            Current:
                            <a href="{{ asset('support_attachments/'.$ticket->attachment) }}" target="_blank">
                                View Attachment
                            </a>
                        </small>
                        @endif
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success">Update Ticket</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
