<table>
    <tr>
        <th>Total Circle Calls</th>
        <td>{{ $totalCircleCalls }}</td>
    </tr>
    <tr>
        <th>Total References</th>
        <td>{{ $totalReferences }}</td>
    </tr>
    <tr>
        <th>Total Business Amount</th>
        <td>{{ $totalBusinessAmount }}</td>
    </tr>
</table>

<br><br>
<h4>IBM Report</h4>
<table>
    <tr>
        <th>Member</th>
        <th>Circle</th>
        <th>IBM Count</th>
    </tr>
    @foreach ($ibms as $row)
        <tr>
            <td>{{ $row['memberName'] }}</td>
            <td>{{ $row['circleName'] }}</td>
            <td>{{ $row['member_count'] }}</td>
        </tr>
    @endforeach
</table>

<br><br>
<h4>References Report</h4>
<table>
    <tr>
        <th>Reference Giver</th>
        <th>Count</th>
    </tr>
    @foreach ($refReport as $row)
        <tr>
            <td>{{ $row['referenceGiverName'] }}</td>
            <td>{{ $row['reference_count'] }}</td>
        </tr>
    @endforeach
</table>

<br><br>
<h4>Business Report</h4>
<table>
    <tr>
        <th>Business Giver</th>
        {{-- <th>Business Count</th> --}}
        <th>Total Amount</th>
    </tr>
    @foreach ($businessReport as $row)
        <tr>
            <td>{{ $row['member'] }}</td>
            {{-- <td>{{ $row['business_count'] }}</td> --}}
            <td>{{ $row['total_amount'] }}</td>
        </tr>
    @endforeach
</table>
