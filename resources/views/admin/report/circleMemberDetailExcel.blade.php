<h2>Circle Member Detailed Report</h2>
<h3>Date: {{ $startDate }} To {{ $endDate }}</h3>

@foreach ($data as $item)
    <h4>{{ $item['member']->firstName }} {{ $item['member']->lastName }}</h4>
    <h5>IBM</h5>
    <table>
        <thead>
        <tr>
            <th>With Member</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($item['ibm'] as $r)
            <tr>
                <td>{{ $r->meetingPersonReport->firstName ?? '' }} {{ $r->meetingPersonReport->lastName ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h5>Business</h5>
    <table>
        <thead>
        <tr>
            <th>To Member</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($item['business'] as $r)
            <tr>
                <td>{{ $r->loginMember->firstName ?? '' }} {{ $r->loginMember->lastName ?? '' }}</td>
                <td>{{ $r->amount }}</td>
                <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h5>Reference</h5>
    <table>
        <thead>
        <tr>
            <th>To Member</th>
            <th>Other Person Name</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($item['reference'] as $r)
            <tr>
                <td>{{ $r->refReceiver->firstName ?? '' }} {{ $r->refReceiver->lastName ?? '' }}</td>
                <td>{{ $r->contactName ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endforeach

