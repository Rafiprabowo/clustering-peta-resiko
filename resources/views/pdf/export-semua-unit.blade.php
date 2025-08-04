<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Risiko Semua Unit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            background-color: #d8e4bc;
            padding: 10px 0;
            margin-bottom: 5px;
        }

        .info {
            margin: 10px 0;
        }

        .info td {
            padding: 3px 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: #c5d9f1;
            text-align: center;
        }

        .risk-very-low {
            background-color: #00b0f0;
        }

        .risk-low {
            background-color: #00b050;
        }

        .risk-middle {
            background-color: #ffff00;
        }

        .risk-high {
            background-color: #ffc000;
        }

        .risk-extreme {
            background-color: #c00000;
        }

        .chart-legend {
            display: inline-block;
            text-align: left;
            margin-top: 15px;
        }

        .chart-legend div {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }

        .chart-legend-box {
            width: 16px;
            height: 16px;
            border: 1px solid #000;
            margin-right: 8px;
            flex-shrink: 0;
        }

        hr.page-break {
            border: none;
            page-break-after: always;
        }
    </style>
</head>

<body>

    @foreach ($units as $unit)
        <h2>IDENTIFIKASI DAN ANALISIS RISIKO</h2>

        <table class="info">
            <tr>
                <td style="border:none;"><strong>Nama Unit Pemilik Risiko</strong></td>
                <td style="border: none;">: {{ $unit['jenis'] }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Tahun</strong></td>
                <td style="border:none;">: {{ date('Y') }}</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Nama Unit <br>(Kode)</th>
                    <th>Usulan Kegiatan</th>
                    <th>Nilai Usulan</th>
                    <th>Skor Probabilitas</th>
                    <th>Skor Dampak</th>
                    <th>Tingkat Risiko</th>
                    <th>SPIP</th>
                    <th>Uraian Dampak</th>
                    <th>Pernyataan Risiko</th>
                    <th>Pengendalian</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unit['data'] as $index => $item)
                    @php
                        $riskClass = match (strtolower($item['tingkatRisiko'])) {
                            'very low' => 'risk-very-low',
                            'low' => 'risk-low',
                            'middle' => 'risk-middle',
                            'high' => 'risk-high',
                            'extreme' => 'risk-extreme',
                            default => '',
                        };
                    @endphp
                    <tr>
                        <td>{{ $unit['jenis'] . '-' . ($index + 1) }}</td>
                        <td>{{ $item['usulanKegiatan'] }}</td>
                        <td>{{ $item['nilUsulan'] }}</td>
                        <td>{{ $item['skorProbabilitas'] }}</td>
                        <td>{{ $item['skorDampak'] }}</td>
                        <td class="{{ $riskClass }}">{{ $item['tingkatRisiko'] }}</td>
                        <td>{{ $item['SPIP'] }}</td>
                        <td>{{ $item['uraianDampak'] }}</td>
                        <td>{{ $item['pernyataanRisiko'] }}</td>
                        <td>{{ $item['pengendalian'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: center; margin-top: 20px;">
            <h3 style="margin-bottom: 70px; font-size: 16px;">PROFIL RISIKO</h3>

            <img src="{{ $chartUrl }}" style="max-width: 600px; display: block; margin: 0 auto;">

            <div style="display: inline-block; text-align: left; margin-top: 15px;">
                @php $total = array_sum($riskCounts); @endphp
                @foreach ($riskCounts as $label => $jumlah)
                    @php
                        $index = $loop->index;
                        $percent = $total > 0 ? round(($jumlah / $total) * 100) : 0;
                    @endphp
                    <div style="display: flex; align-items: center; margin-bottom: 6px;">
                        <div
                            style="
                    width: 16px;
                    height: 16px;
                    background-color: {{ $colors[$index] }};
                    border: 1px solid #000;
                    margin-right: 8px;
                    flex-shrink: 0;">
                        </div>
                        <div style="font-size: 13px; line-height: 1.2;">
                            {{ $label }} ({{ $jumlah }} / {{ $percent }}%)
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if (!$loop->last)
            <hr class="page-break">
        @endif
    @endforeach

</body>

</html>
