<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['name'] }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; direction: rtl; padding: 20px; }
        h1 { text-align: center; color: #3D4F5F; margin-bottom: 10px; }
        .date { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #3D4F5F; color: #fff; padding: 10px; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; text-align: center; }
        tr:nth-child(even) { background: #f9f9f9; }
    </style>
</head>
<body>
    <h1>{{ $data['name'] }}</h1>
    <p class="date">تاريخ التقرير: {{ date('Y-m-d') }}</p>
    
    <table>
        <thead>
            <tr>
                @foreach($data['headers'] as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data['rows'] as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
