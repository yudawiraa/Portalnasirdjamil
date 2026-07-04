<table>
    <thead>
        <tr>
            @foreach ($headings as $heading)
                <th>{{ $heading }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $aspirasi)
            <tr>
                <td>{{ $aspirasi->code }}</td>
                <td>{{ optional($aspirasi->submitted_at)->format('Y-m-d H:i:s') }}</td>
                <td>{{ $aspirasi->name }}</td>
                <td>{{ $aspirasi->whatsapp }}</td>
                <td>{{ $aspirasi->email }}</td>
                <td>{{ $aspirasi->city }}</td>
                <td>{{ $aspirasi->district_village }}</td>
                <td>{{ $aspirasi->category?->name }}</td>
                <td>{{ $aspirasi->title }}</td>
                <td>{{ $aspirasi->body }}</td>
                <td>{{ $aspirasi->statusLabelText() }}</td>
                <td>{{ $aspirasi->priorityLabelText() }}</td>
                <td>{{ $aspirasi->assigned_to }}</td>
                <td>{{ $aspirasi->verification_result }}</td>
                <td>{{ $aspirasi->public_response }}</td>
                <td>{{ $aspirasi->internal_note }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
