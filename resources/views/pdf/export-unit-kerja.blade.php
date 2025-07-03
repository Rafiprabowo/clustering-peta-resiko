<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Peta Risiko</title>
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

        .center {
            text-align: center;
        }

        .risk-very-low {
            background-color: #00b0f0;
            /* biru muda */
        }

        .risk-low {
            background-color: #00b050;
            /* hijau muda */
        }

        .risk-middle {
            background-color: #ffff00;
            /* kuning muda */
        }

        .risk-high {
            background-color: #ffc000;
            /* orange muda */
        }

        .risk-extreme {
            background-color: #c00000;
            /* merah muda */
        }

        .chart-wrapper {
            display: flex;
        }
    </style>

</head>

<body>
    <h2>IDENTIFIKASI DAN ANALISIS RISIKO</h2>

    <table class="info">
        <tr>
            <td style="border:none;"><strong>Nama Unit Pemilik Risiko</strong></td>
            <td style="border: none;">: {{ $jenis }}</td>
        </tr>
        <tr>
            <td style="border: none;"><strong>Tahun</strong></td>
            <td style="border:none;">: {{ $tahun }}</td>
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
                <th>Tingkat Resiko</th>
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
            @foreach ($data as $item)
                @php
                    $riskClass = '';
                    switch (strtolower($item['tingkatRisiko'])) {
                        case 'very low':
                            $riskClass = 'risk-very-low';
                            break;
                        case 'low':
                            $riskClass = 'risk-low';
                            break;
                        case 'middle':
                            $riskClass = 'risk-middle';
                            break;
                        case 'high':
                            $riskClass = 'risk-high';
                            break;
                        case 'extreme':
                            $riskClass = 'risk-extreme';
                            break;
                    }
                @endphp
                <tr>
                    <td>{{ $jenis . '-' . $loop->iteration }}</td>
                    <td>{{ $item['usulanKegiatan'] }}</td>
                    <td>{{ $item['nilUsulan'] }}</td>
                    <td>{{ $item['skorProbabilitas'] ?? '-' }}</td>
                    <td>{{ $item['skorDampak'] ?? '-' }}</td>
                    <td class="{{ $riskClass }}">{{ $item['tingkatRisiko'] }}</td>
                    <td>{{ $item['SPIP'] ?? '-' }}</td>
                    <td>{{ $item['uraianDampak'] }}</td>
                    <td>{{ $item['pernyataanRisiko'] }}</td>
                    <td>{{ $item['pengendalian'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


   <div style="page-break-before: always;"></div>

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
                <div style="
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




    {{--
    <div style="display: flex;">
        <h1>Profil Risiko</h1>
        <div>
            <img src="{{ $chartUrl }}" alt="Chart Risiko - Jumlah" style="max-width: 60%; height: auto;">
        </div>
        <div>
            @php $total = array_sum($riskCounts); @endphp
            @foreach ($riskCounts as $label => $jumlah)
                @php
                    $index = $loop->index;
                    $percent = $total > 0 ? round(($jumlah / $total) * 100) : 0;
                @endphp
                <div style="display: flex; align-items: center; margin-bottom: 6px;">
                    <div
                        style="width: 14px; height: 14px; background-color: {{ $colors[$index] }}; margin-right: 8px;">
                    </div>
                    <span>{{ $label }} ({{ $jumlah }} / {{ $percent }}%)</span>
                </div>
            @endforeach
        </div>
    </div> --}}
    {{-- <div style="display: flex; justify-content: center; align-items: center; margin-top: 30px; ">
        <h1>Profil Risiko</h1> --}}
    {{-- Chart di kiri --}}
    {{-- <div style="width: 60%;">
            <img src="{{ $chartUrl }}" alt="Chart Risiko - Jumlah"
                style="max-width: 0%; height: auto;">
        </div> --}}

    {{-- Legend di kanan --}}
    {{-- <div style="width: 40%; padding-left: 10px;">

        </div> --}}
    {{-- </div> --}}



</body>

</html>
