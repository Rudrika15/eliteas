<h2>Report for: {{ $member->firstName }} {{ $member->lastName }}</h2>
<h3>Date : {{ $startDate }} To {{ $endDate }}</h3>

<h4>IBM (Meetings)</h4>
<table>
    <thead>
        <tr>
            <th class="fw-bold">With Member</th>
            {{-- <th class="fw-bold">Date</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($circleCall as $ibm)
            <tr>
                <td>{{ $ibm->meetingPersonReport->firstName ?? '' }} {{ $ibm->meetingPersonReport->lastName ?? '' }}</td>
                {{-- <td>{{ \Carbon\Carbon::parse($ibm->created_at)->format('d-m-Y') }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>

<h4>Business</h4>
<table>
    <thead>
        <tr>
            <th class="fw-bold">To Member</th>
            <th class="fw-bold">Amount</th>
            {{-- <th class="fw-bold">Date</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($business as $b)
            <tr>
                <td>{{ $b->loginMember->firstName ?? '' }} {{ $b->loginMember->lastName ?? '' }}</td>
                <td>{{ $b->amount }}</td>
                {{-- <td>{{ \Carbon\Carbon::parse($b->created_at)->format('d-m-Y') }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>

<h4>Reference</h4>
<table>
    <thead>
        <tr>
            <th class="fw-bold">To Member</th>
            <th class="fw-bold">Other Person Name</th>
            {{-- <th class="fw-bold">Date</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($reference as $r)
            <tr>
                <td>{{ $r->refReceiver->firstName ?? '' }} {{ $r->refReceiver->lastName ?? '' }}</td>
                <td>{{ $r->contactName ?? '' }} </td>
                {{-- <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d-m-Y') }}</td> --}}
            </tr>
        @endforeach
    </tbody>
</table>
