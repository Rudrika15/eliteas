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
        @foreach ($reportData as $data)
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
