<table>
    <thead>
        <tr>
            <th colspan="11" style="text-align: center; font-weight: bold;">
                {{ $circleName }} Circle Activity Report @if ($startDate && $endDate)
({{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }})
                @endif
            </th>
        </tr>
        <tr>
            <th style="font-weight: bold;">Member Name</th>
            <th style="font-weight: bold;">IBM</th>
            <th style="font-weight: bold;">Ref Given Inside</th>
            <th style="font-weight: bold;">Ref Given Outside</th>
            <th style="font-weight: bold;">Ref Received Inside</th>
            <th style="font-weight: bold;">Ref Received Outside</th>
            <th style="font-weight: bold;">Business Given</th>
            <th style="font-weight: bold;">Business Received</th>
            <th style="font-weight: bold;">Training</th>
            <th style="font-weight: bold;">Testimonial Given</th>
            <th style="font-weight: bold;">Testimonial Received</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activityReportData as $data)
            <tr>
                <td>{{ $data['member_name'] }}</td>
                <td>{{ $data['ibm'] }}</td>
                <td>{{ $data['ref_given_inside'] }}</td>
                <td>{{ $data['ref_given_outside'] }}</td>
                <td>{{ $data['ref_received_inside'] }}</td>
                <td>{{ $data['ref_received_outside'] }}</td>
                <td>{{ $data['business_given'] }}</td>
                <td>{{ $data['business_received'] }}</td>
                <td>{{ $data['training'] }}</td>
                <td>{{ $data['testimonial_given'] }}</td>
                <td>{{ $data['testimonial_received'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align: center; font-weight: bold;">
                {{ $circleName }} Attendance Report @if ($startDate && $endDate)
                    ({{ $startDate }} to {{ $endDate }})
                @endif
            </th>
        </tr>
        <tr>
            <th style="font-weight: bold;">No</th>
            <th style="font-weight: bold;">Member Name</th>
            <th style="font-weight: bold;">P - Presence</th>
            <th style="font-weight: bold;">A - Absent</th>
            <th style="font-weight: bold;">L - Late</th>
            <th style="font-weight: bold;">M - Medical</th>
            <th style="font-weight: bold;">S - Substitute</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendanceReportData as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data['member_name'] }}</td>
                <td>{{ $data['present'] }}</td>
                <td>{{ $data['absent'] }}</td>
                <td>{{ $data['late'] }}</td>
                <td>{{ $data['medical'] }}</td>
                <td>{{ $data['substitute'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
