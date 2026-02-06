@extends('layouts.master')

@section('title', 'UBN - Attendance')
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


    <div id="attendanceLoader" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.25); z-index:2000;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); background:#fff; padding:14px 18px; border-radius:10px; display:flex; align-items:center; gap:10px;">
            <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>
            <div>Saving...</div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title">Take Attendance of Circle Members</h5>
                <div>
                    @if (isset($currentMeeting->is_locked) && $currentMeeting->is_locked)
                        <a href="{{ route('attendance.toggleLock', $meetingId) }}" class="btn btn-danger btn-sm me-2">
                            <i class="bi bi-lock-fill"></i> Unlock
                        </a>
                    @else
                        <a href="{{ route('attendance.toggleLock', $meetingId) }}" class="btn btn-success btn-sm me-2">
                            <i class="bi bi-unlock-fill"></i> Lock
                        </a>
                    @endif
                    <a href="{{ route('attendance.meetingSchedules') }}" class="btn btn-bg-orange btn-sm">BACK</a>
                </div>
            </div>
            <form id="attendanceForm" action="{{ route('attendance.attendanceStore') }}" method="POST">
                @csrf

                <input type="hidden" name="circleId" value="{{ $circleId }}">
                <input type="hidden" name="meetingId" value="{{ $meetingId }}">

                <!-- Add margin around the table -->
                <div class="table-responsive m-3">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th>Name</th>
                                <th class="text-center">IBM</th>
                                <th class="text-center">Ref</th>
                                <th class="text-center">Biz</th>
                                <th width="15%">Fill the Status</th>
                                {{-- <th width="5%"><input type="checkbox" id="checkAll"> Select All </th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($circleMembers as $member)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $member->firstName }} {{ $member->lastName }}</td>
                                    <td class="text-center">{{ $member->ibmCount ?? 0 }}</td>
                                    <td class="text-center">{{ $member->refCount ?? 0 }}</td>
                                    <td class="text-center">{{ $member->bizCount ?? 0 }}</td>
                                    <td>
                                        @php
                                            $attendance = App\Models\CircleMeetingsAttendances::where('circleId', $circleId)->where('meetingId', $meetingId)->where('userId', $member->userId)->first();
                                        @endphp

                                        <select name="attendance[{{ $member->userId }}]" class="form-select attendance-select status-select {{ strtolower($attendance?->status ?? 'none') }}">
                                            <option value="">Select Status</option>
                                            <option value="Present" {{ ($attendance?->status ?? 'Present') == 'Present' ? 'selected' : '' }}>Present</option>
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

                <!-- Buttons with margin on top -->
                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-bg-blue">Submit</button>
                    <button type="reset" class="btn btn-bg-orange">Reset</button>
                </div>
            </form>
        </div>
    </div>

@endsection


{{--
<div class="card">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title">Take Attendance of Invited Peoples</h5>
    </div>
    <form action="{{ route('attendance.attendanceStore') }}" method="POST">
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
                    <td><input type="checkbox" name="personName[]" value="{{ $meetingInvitationsData->personName }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center mb-3">
            <button type="submit" class="btn btn-bg-blue">Submit</button>
            <button type="reset" class="btn btn-bg-orange">Reset</button>
        </div>
    </form>
</div> --}}

{{-- @section('scripts')
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function() {
                var isChecked = $(this).is(':checked');
                $('tbody input:checkbox').prop('checked', isChecked);
            });
        });
    </script>
@endsection --}}


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.attendance-select').on('change', function() {
            $(this)
                .removeClass('present absent late medical sub none')
                .addClass($(this).val().toLowerCase() || 'none');
        });
    </script>


    <script>
        $(function() {

            const $loader = $('#attendanceLoader');

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

            $(document).on('change', '.attendance-select', function() {
                const $select = $(this);
                const userIdMatch = ($select.attr('name') || '').match(/^attendance\[(\d+)\]$/);
                if (!userIdMatch) {
                    return;
                }

                const userId = userIdMatch[1];
                const status = $select.val() || null;
                const circleId = $('input[name="circleId"]').val();
                const meetingId = $('input[name="meetingId"]').val();

                setLoading(true);

                $.ajax({
                    url: @json(route('attendance.updateStatus')),
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        _token: @json(csrf_token()),
                        circleId,
                        meetingId,
                        userId,
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

            $('#attendanceForm').on('submit', function() {
                setLoading(true);
            });

            $('#selectAllStatus').on('change', function() {
                let status = $(this).val();

                $('.attendance-select').val(status);

                Swal.fire({
                    icon: 'success',
                    title: 'Done',
                    text: 'Status applied to all',
                    timer: 1200,
                    showConfirmButton: false
                });
            });

        });
    </script>
@endsection
