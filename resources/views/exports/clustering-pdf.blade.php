<!DOCTYPE html>
<html>

<head>
    <title>Hasil Clustering</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background-color: #eee;
        }

        h3 {
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">Hasil Clustering Berdasarkan IKU dan ID Usulan</h2>

    @foreach ($data as $cluster => $rows)
        @php
            $label = $rows->first()['label'];
        @endphp

        <h3>Klaster {{ $cluster }} ({{ $label }})</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>IKU</th>
                    <th>ID Usulan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $index => $row)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $row['iku'] }}</td>
                        <td>{{ $row['id_usulan'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>

</html>
