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
                        <div class="col-md-4">
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

                        <div class="col-md-4">
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

                        <div class="col-md-4 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-bg-blue btn-sm w-100">Get Report</button>
                            <a href="{{ route('admin.memberWiseReport') }}" class="btn btn-bg-orange btn-sm w-100">Reset</a>
                        </div>
                    </div>
                </form>

                @if (request('memberId'))
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card border-success shadow-sm border">
                                <div class="card-body text-center">
                                    <h6 class="mt-4 fw-bold">Total Business Amount</h6>
                                    <h4 class="text-success">₹{{ number_format($totalBusinessAmount, 2) }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-info shadow-sm border">
                                <div class="card-body text-center">
                                    <h6 class="mt-4 fw-bold">Total IBM Count</h6>
                                    <h4 class="text-info">{{ $totalIbmCount }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-warning shadow-sm border">
                                <div class="card-body text-center">
                                    <h6 class="mt-4 fw-bold">Total Reference Count</h6>
                                    <h4 class="text-warning">{{ $totalReferenceCount }}</h4>
                                </div>
                            </div>
                        </div>
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
