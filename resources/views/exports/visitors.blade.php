<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Business Category</th>
            <th>City</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($visitors as $visitor)
            <tr>
                <td>{{ $visitor->firstName }} {{ $visitor->lastName }}</td>
                <td>{{ $visitor->bCategory->categoryName ?? 'N/A' }}</td>
                <td>{{ $visitor->city }}</td>
                <td>{{ $visitor->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
