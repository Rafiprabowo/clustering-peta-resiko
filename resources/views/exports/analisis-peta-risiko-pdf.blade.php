<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Peta Risiko PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h3, h4 {
            text-align: center;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            border: 1px solid #999;
            padding: 5px;
            text-align: center;
        }

        .no-border td {
            border: none;
        }
    </style>
</head>

<body>
    <h3>Analisis Peta Risiko - {{ $namaFile }}</h3>

    <h3>Visualisasi Jumlah Kegiatan & IKU per Cluster</h3>
    <table class="no-border">
        <tr>
            <td width="50%">
                <h4>Jumlah Kegiatan di Tiap Cluster</h4>
                <img src="{{ $chartKegiatan }}" alt="Chart Total Kegiatan" width="300" style="max-width:100%;">
            </td>
            <td width="50%">
                <h4>Jumlah IKU Tercapai di Tiap Cluster</h4>
                <img src="{{ $chartIku }}" alt="Chart Total IKU" width="300" style="max-width:100%;">
            </td>
        </tr>
    </table>

    <h3>Rentang & Rata-rata Data Tiap Cluster</h3>
    <table>
        <thead>
            <tr>
                <th rowspan="2">Cluster</th>
                <th colspan="2">IKU</th>
                <th colspan="2">Anggaran</th>
                <th colspan="2">Tingkat Risiko</th>
            </tr>
            <tr>
                <th>Min - Max</th>
                <th>Rata-rata</th>
                <th>Min - Max</th>
                <th>Rata-rata</th>
                <th>Min - Max</th>
                <th>Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clusterStats as $stat)
                <tr>
                    <td>Cluster {{ $stat['cluster'] }}</td>
                    <td>{{ $stat['min_iku'] }} - {{ $stat['max_iku'] }}</td>
                    <td>{{ $stat['avg_iku'] }}</td>
                    <td>Rp {{ number_format($stat['min_anggaran'], 0, ',', '.') }} - Rp {{ number_format($stat['max_anggaran'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($stat['avg_anggaran'], 0, ',', '.') }}</td>
                    <td>{{ $stat['min_risiko'] }} - {{ $stat['max_risiko'] }}</td>
                    <td>{{ $stat['avg_risiko'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Distribusi IKU per Cluster</h3>
    @foreach ($ikuPerCluster as $clusterId => $ikus)
        <h4>Cluster {{ $clusterId }}</h4>
        <table>
            <thead>
                <tr>
                    <th>IKU</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ikus as $iku => $data)
                    <tr>
                        <td>{{ $iku }}</td>
                        <td>{{ $data['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
