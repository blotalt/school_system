<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: DejaVu Sans, sans-serif; color: #1f2430; font-size: 12px; }
    .school-name { font-size: 18px; font-weight: bold; color: #0b3f86; margin-bottom: 2px; }
    .generated-at { font-size: 10px; color: #8a94a6; margin-bottom: 18px; }
    h1 { font-size: 15px; margin: 0 0 16px 0; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #e5e9f2; padding: 6px 10px; text-align: left; }
    th { background: #0b3f86; color: #fff; font-size: 11px; text-transform: uppercase; }
    tr:nth-child(even) td { background: #f7f9fc; }
</style>
</head>
<body>
    <div class="school-name">Cambodia High School</div>
    <div class="generated-at">Generated {{ $generatedAt }}</div>
    <h1>{{ $title }}</h1>
    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr><td colspan="{{ count($headers) }}" style="text-align:center;color:#8a94a6;">No data</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
