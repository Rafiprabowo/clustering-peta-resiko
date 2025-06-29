@extends('layout.app')
@section('title', 'Detail Clustering')
@section('main')
    <style>
        .table-responsive-custom {
            overflow-x: auto;
        }

        .table td,
        .table th {
            white-space: pre-wrap;
            /* wrap teks panjang */
            word-wrap: break-word;
            /* pecah kata panjang */
            vertical-align: top;
            /* biar teks atas sel */
        }
    </style>

    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Detail Clustering</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <h5>Data Awal</h5>
                                <div class="table-responsive table-responsive-custom">
                                    <table class="table table-bordered table-sm">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="width: 50px;">No</th>
                                                <th style="width: 150px;">Nama Unit</th>
                                                <th style="width: 150px;">IKU</th>
                                                <th style="width: 250px;">Judul</th>
                                                <th style="width: 120px;">Anggaran</th>
                                                <th style="width: 120px;">Skor Probabilitas</th>
                                                <th style="width: 120px;">Skor Dampak</th>
                                                <th style="width: 300px;">Uraian</th>
                                                <th style="width: 300px;">Pernyataan</th>
                                                <th style="width: 300px;">Pengendalian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($petaAwals as $index => $awal)
                                                <tr>
                                                    <td>{{ $petaAwals->firstItem() + $index }}</td>
                                                    <td>{{ $awal->nmUnit }}</td>
                                                    <td>{{ $awal->iku }}</td>
                                                    <td>{{ $awal->nmKegiatan }}</td>
                                                    <td>{{ number_format($awal->nilRabUsulan, 0, ',', '.') }}</td>
                                                    <td>{{ $awal->probaBilitas }}</td>
                                                    <td>{{ $awal->dampak }}</td>
                                                    <td>{{ $awal->uraianDampak }}</td>
                                                    <td>{{ $awal->pernyataanRisiko }}</td>
                                                    <td>{{ $awal->pengendalian }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                {{ $petaAwals->links('pagination::bootstrap-4') }}


                                <h5 class="mt-4">Data Cleaned & Preprocessing</h5>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Unit</th>
                                            <th>Kegiatan</th>
                                            <th>Transform</th>
                                            <th>Normalisasi</th>
                                            <th>Cluster</th>
                                            <th>Interpretasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clusteringRun->petaCleaneds as $index => $cleaned)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $cleaned->nmUnit }}</td>
                                                <td>{{ $cleaned->nmKegiatan }}</td>
                                                <td>{{ $cleaned->preprocessing->transform ?? '-' }}</td>
                                                <td>{{ $cleaned->preprocessing->normalisasi ?? '-' }}</td>
                                                <td>{{ $cleaned->cluster->cluster ?? '-' }}</td>
                                                <td>{{ $cleaned->cluster->interpretasi->interpretasi ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
