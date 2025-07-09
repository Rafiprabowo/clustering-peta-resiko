<!DOCTYPE html>
<html>
<head>
    <title>Data Clustering</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
        }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Data Clustering - {{ $namaFile }}</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Unit</th>
                <th>IKU</th>
                <th>Nama Kegiatan</th>
                <th>Nilai Anggaran</th>
                <th>Skor Dampak</th>
                <th>Skor Probabilitas</th>
                <th>Tingkat Risiko</th> <!-- Baru -->
                <th>Kategori Risiko</th>
                <th>Pernyataan Risiko</th>
                <th>Uraian Dampak</th>
                <th>Pengendalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->nama_unit }}</td>
                    <td>{{ $item->iku }}</td>
                    <td>{{ $item->nama_kegiatan }}</td>
                    <td>{{ number_format($item->nilai_anggaran, 0, ',', '.') }}</td>
                    <td>{{ $item->dampak }}</td>
                    <td>{{ $item->probabilitas }}</td>
                    <td>{{ $item->tingkat_risiko }}</td> <!-- Baru -->
                    <td>{{ $item->kategori_risiko }}</td>
                    <td>{{ $item->pernyataan_risiko }}</td>
                    <td>{{ $item->uraian_dampak }}</td>
                    <td>{{ $item->pengendalian }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
