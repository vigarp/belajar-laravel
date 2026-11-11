<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Projects</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
        }
        h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            padding: 8px 6px;
            text-align: center;
            font-weight: bold;
        }
        td {
            padding: 8px 6px;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .img-project {
            max-width: 80px;
            max-height: 80px;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h2>Data Projects</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Gambar</th>
                <th style="width: 15%;">Title</th>
                <th style="width: 15%;">Teknologi</th>
                <th style="width: 40%;">Description</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        @if ($project->image && file_exists(public_path('images/' . $project->image)))
                            <img src="{{ public_path('images/' . $project->image) }}" class="img-project" alt="{{ $project->title }}">
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->teknologi }}</td>
                    <td>{{ $project->description }}</td>
                    <td class="text-center">{{ $project->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
