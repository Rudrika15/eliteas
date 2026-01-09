@extends('layouts.master')

@section('title', 'Attendance')
@section('content')

    <style>
        .status-select.present {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-select.absent {
            background: #f8d7da;
            color: #842029;
        }

        .status-select.late {
            background: #fff3cd;
            color: #664d03;
        }

        .status-select.medical {
            background: #cff4fc;
            color: #055160;
        }

        .status-select.sub {
            background: #e2e3e5;
            color: #41464b;
        }

        .status-select.none {
            background: #f8f9fa;
            color: #6c757d;
        }
    </style>


    <div id="invitedAttendanceLoader" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.25); z-index:2000;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:#fff; padding:14px 18px; border-radius:10px; display:flex; align-items:center; gap:10px;">
            <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>
            <div>Saving...</div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Take Attendance of Invited Peoples</h5>
                <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
            </div>
            <form id="invitedAttendanceForm" action="{{ route('attendance.invitedAttendanceStore') }}" method="POST">
                @csrf

                <input type="hidden" name="circleId" value="{{ $circleId }}">
                <input type="hidden" name="meetingId" value="{{ $meetingId }}">

                <div class="table-responsive m-3">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Name</th>
                                <th width="20%" class="text-center">Select Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meetingInvitations as $meetingInvitationsData)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $meetingInvitationsData->personName }}</td>
                                    <td>
                                        @php
                                            $attendance = \App\Models\CircleMeetingsAttendances::where('circleId', $circleId)->where('meetingId', $meetingId)->where('name', $meetingInvitationsData->personName)->first();
                                        @endphp

                                        <input type="hidden" name="attendance[{{ $loop->index }}][name]" value="{{ $meetingInvitationsData->personName }}">

                                        <select name="attendance[{{ $loop->index }}][status]" class="form-select invited-attendance-select status-select {{ strtolower($attendance?->status ?? 'none') }}" data-person-name="{{ $meetingInvitationsData->personName }}">

                                            <option value="">Select Status</option>

                                            <option value="Present" {{ $attendance?->status == 'Present' ? 'selected' : '' }}>Present</option>
                                            <option value="Absent" {{ $attendance?->status == 'Absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="Late" {{ $attendance?->status == 'Late' ? 'selected' : '' }}>Late</option>
                                            <option value="Medical" {{ $attendance?->status == 'Medical' ? 'selected' : '' }}>Medical</option>
                                            <option value="Sub" {{ $attendance?->status == 'Sub' ? 'selected' : '' }}>Sub</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            const $loader = $('#invitedAttendanceLoader');

            function setLoading(isLoading) {
                if (isLoading) {
                    $loader.show();
                } else {
                    $loader.hide();
                }
            }

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: @json(session('success')),
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: @json($errors->first()),
                });
            @endif

            $(document).on('change', '.invited-attendance-select', function() {
                const $select = $(this);
                const personName = $select.data('person-name');
                const status = $select.val() || null;
                const circleId = $('input[name="circleId"]').val();
                const meetingId = $('input[name="meetingId"]').val();

                setLoading(true);

                $.ajax({
                    url: @json(route('attendance.updateInvitedStatus')),
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: @json(csrf_token()),
                        circleId,
                        meetingId,
                        personName,
                        status
                    }
                }).done(function(resp) {
                    if (resp && resp.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved',
                            text: resp.message || 'Attendance saved',
                            timer: 900,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: (resp && resp.message) ? resp.message : 'Failed to save attendance'
                        });
                    }
                }).fail(function(xhr) {
                    let message = 'Failed to save attendance';
                    if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: message
                    });
                }).always(function() {
                    setLoading(false);
                });
            });

            $('#selectAllInvitedStatus').on('change', function() {
                const status = $(this).val() || '';
                $('.invited-attendance-select').each(function() {
                    $(this).val(status).trigger('change');
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Done',
                    text: 'Status applied to all',
                    timer: 1200,
                    showConfirmButton: false
                });
            });

            $('#invitedAttendanceForm').on('submit', function() {
                setLoading(true);
            });
        });
    </script>


    <script>
        $('.invited-attendance-select').on('change', function() {
            $(this)
                .removeClass('present absent late medical sub none')
                .addClass($(this).val().toLowerCase() || 'none');
        });
    </script>

@endsection
