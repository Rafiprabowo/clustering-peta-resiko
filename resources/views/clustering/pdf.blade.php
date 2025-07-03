<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hasil Clustering Detail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            /* Kecilkan font */
            margin: 0;
            padding: 0;
        }

        h2,
        h3,
        h4,
        p {
            margin: 2px 0;
            /* Buat rapat atas-bawah */
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px;
            /* Perkecil padding */
            vertical-align: top;
        }

        th {
            text-align: center;
            background-color: #f0f0f0;
        }

        .header-info p {
            margin: 1px 0;
            font-size: 9px;
        }
    </style>

</head>

<body>
    <h2>Hasil Clustering Peta Risiko</h2>
    <p><strong>Nama File:</strong> {{ $clusteringRun->nama_file }}</p>
    <p><strong>Metode:</strong> {{ $clusteringRun->metode }}</p>
    <p><strong>Silhouette Score:</strong> {{ $clusteringRun->silhouette_score }}</p>
    <p><strong>Tanggal:</strong> {{ $tanggal }}</p>

    <table>
        <thead>
            <tr>
                <th>ID Usulan</th>
                <th>Nama Unit</th>
                <th>IKU</th>
                <th>Nama Kegiatan</th>
                <th>Nilai RAB Usulan</th>
                <th>Pernyataan Risiko</th>
                <th>Uraian Dampak</th>
                <th>Pengendalian</th>
                <th>Resiko</th>
                <th>Skor Dampak</th>
                <th>Skor Probabilitas</th>
                <th>Cluster</th>
                <th>Interpretasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($petaCleaneds as $index => $row)
                <tr>
                    <td>{{ $row->idUsulan }}</td>
                    <td>{{ $row->nmUnit }}</td>
                    <td>{{ $row->iku }}</td>
                    <td>{{ $row->nmKegiatan }}</td>
                    <td>{{ $row->nilRabUsulan }}</td>
                    <td>{{ $row->pernyataanRisiko }}</td>
                    <td>{{ $row->uraianDampak }}</td>
                    <td>{{ $row->pengendalian }}</td>
                    <td>{{ $row->Resiko }}</td>
                    <td>{{ $row->preprocessing['transform']['dampak'] }}</td>
                    <td>{{ $row->preprocessing['transform']['probaBilitas'] }}</td>
                    <td>{{ $row->cluster?->cluster ?? '-' }}</td>
                    <td>{{ $row->cluster?->interpretasi?->interpretasi ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <table width="100%" style="text-align: center; margin-top: 20px; border-collapse: collapse;">
    <tr>
        <td style="border: 1px solid #ccc; padding: 10px;">
            <h4>Distribusi Jumlah Kegiatan berdasarkan Cluster</h4>
            <img src="{{ $kegiatanChartUrl }}" alt="Chart Cluster" style="width: 500px;">
        </td>
        <td style="border: 1px solid #ccc; padding: 10px;">
            <h4>Total IKU berdasarkan Cluster</h4>
            <img src="{{ $ikuChartUrl }}" alt="Chart Total IKU" style="width: 500px;">
        </td>
    </tr>
</table>
</body>

</html>
