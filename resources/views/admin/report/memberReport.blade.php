@extends('layouts.master')

@section('title', 'UBN - Members Report')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Member Report Summary</h4>
                </div>

                <form method="GET" action="{{ route('admin.memberWiseReport') }}" id="memberFilterForm">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="circleId"><strong>Circle:</strong></label>
                            <select name="circleId" id="circleId" class="form-control form-control-sm">
                                <option value="">-- Select Circle --</option>
                                @foreach ($circle as $c)
                                    <option value="{{ $c->id }}" {{ request('circleId') == $c->id ? 'selected' : '' }}>
                                        {{ $c->circleName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="memberId"><strong>Member:</strong></label>
                            <select name="memberId" id="memberId" class="form-control form-control-sm">
                                <option value="">-- Select Member --</option>
                                @foreach ($member as $m)
                                    @if (request('circleId') == $m->circleId)
                                        <option value="{{ $m->id }}" {{ request('memberId') == $m->id ? 'selected' : '' }}>
                                            {{ $m->firstName }} {{ $m->lastName }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="start_date"><strong>Start Date:</strong></label>
                            <input type="date" name="start_date" value="{{ request()->input('start_date') }}" class="form-control form-control-sm">
                        </div>

                        <div class="col-md-2">
                            <label for="end_date"><strong>End Date:</strong></label>
                            <input type="date" name="end_date" value="{{ request()->input('end_date') }}" class="form-control form-control-sm">
                        </div>

                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-bg-blue btn-sm w-100">Get Report</button>
                            <a href="{{ route('admin.memberWiseReport') }}" class="btn btn-bg-orange btn-sm w-100">Reset</a>
                        </div>
                    </div>
                </form>

                {{-- @if (request('memberId'))
                    <div class="text-end mb-2">
                        <a href="{{ route('admin.memberWiseReport', request()->all()) }}" class="btn btn-success btn-sm">Export Excel</a>
                    </div>
                @endif --}}


                @if (request('memberId'))
                    <form method="GET" action="{{ route('admin.memberWiseReport') }}">
                        <input type="hidden" name="memberId" value="{{ request('memberId') }}">
                        <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                        <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                        <input type="hidden" name="export" value="1">
                        <button type="submit" class="btn btn-success btn-sm mt-3">Download Excel</button>
                    </form>
                @endif


                @if (request('memberId') && $selectedMember)
                    <div class="mt-4">
                        <h5 class="fw-bold color-orange">Report for: <span class="color-blue">{{ $selectedMember->firstName }} {{ $selectedMember->lastName }} </span></h5>
                        <h5 class="fw-bold">Date : {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} To {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</h5>

                    </div>
                @endif


                @if (request('memberId'))

                    {{-- IBM Details --}}
                    <div class="mt-5">
                        <h5 class="fw-bold">IBM (Meetings) Details</h5>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>With Member</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($circleCall as $ibm)
                                    <tr>
                                        <td>{{ $ibm->meetingPersonReport->firstName ?? '' }} {{ $ibm->meetingPersonReport->lastName ?? '' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($ibm->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No IBM records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Business Details --}}
                    <div class="mt-4">
                        <h5 class="fw-bold">Business Given</h5>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>To Member</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($business as $b)
                                    <tr>
                                        <td>{{ $b->loginMember->firstName ?? '' }} {{ $b->loginMember->lastName ?? '' }}</td>
                                        <td>₹{{ number_format($b->amount, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No business records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Reference Details --}}
                    <div class="mt-4">
                        <h5 class="fw-bold">References Given</h5>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>To Member</th>
                                    <th>Other Person Name</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reference as $r)
                                    <tr>
                                        <td>{{ $r->refReceiver->firstName ?? '' }} {{ $r->refReceiver->lastName ?? '' }}</td>
                                        <td>{{ $r->contactName ?? '' }} </td>
                                        <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No reference records</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const circleDropdown = document.getElementById('circleId');
        const memberDropdown = document.getElementById('memberId');
        const selectedMemberId = "{{ request('memberId') }}";

        circleDropdown.addEventListener('change', function() {
            const circleId = this.value;

            // Clear existing members
            memberDropdown.innerHTML = '<option value="">-- Select Member --</option>';

            if (circleId) {
                fetch(`/get-members/${circleId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(member => {
                            const option = document.createElement('option');
                            option.value = member.userId;
                            option.textContent = member.firstName + ' ' + member.lastName;
                            if (member.id == selectedMemberId) {
                                option.selected = true;
                            }
                            memberDropdown.appendChild(option);
                        });
                    });

            }
        });

        // Auto-trigger on page load if circle is already selected
        document.addEventListener('DOMContentLoaded', function() {
            if (circleDropdown.value) {
                circleDropdown.dispatchEvent(new Event('change'));
            }
        });
    </script>

    <script>
        document.getElementById('resetButton')?.addEventListener('click', function() {
            document.getElementById('memberFilterForm').reset();
        });
    </script>

@endsection
