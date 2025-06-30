@extends('layout.app')
@section('title', 'Detail Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Detail Clustering </h1>
            </div>
            <div class="section-body">
                <h4 class="tittle-1">
                    <span class="span0">Nama File : {{  $clusteringRun->nama_file }}</span>
                    {{-- <span class="span1">{{ $jenis }}</span> --}}
                </h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header">
                                <h5>Data Peta Risiko Sebelum Cleaning</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Unit</th>
                                            <th>IKU</th>
                                            <th>Judul</th>
                                            <th>Anggaran</th>
                                            <th>Skor Probabilitas</th>
                                            <th>Skor Dampak</th>
                                            <th>Uraian</th>
                                            <th>Resiko</th>
                                            <th>Pernyataan</th>
                                            <th>Pengendalian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($petaAwals as $index => $item)
                                            <tr>
                                                <td class="align-top">
                                                    {{ ($petaAwals->currentPage() - 1) * $petaAwals->perPage() + $index + 1 }}
                                                </td>
                                                <td class="align-top">{{ $item->nmUnit }}</td>
                                                <td class="align-top">{{ $item->iku }}</td>
                                                <td class="align-top">{{ $item->nmKegiatan }}</td>
                                                <td class="align-top">{{ $item->nilRabUsulan }}</td>
                                                <td class="align-top">{{ $item->probaBilitas }}</td>
                                                <td class="align-top">{{ $item->dampak }}</td>
                                                <td class="align-top">{{ $item->uraianDampak }}</td>
                                                <td class="align-top">{{ $item->Resiko }}</td>
                                                <td class="align-top">{{ $item->pernyataanRisiko }}</td>
                                                <td class="align-top">{{ $item->pengendalian }}</td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Peta Risio belum Tersedia
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $petaAwals->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Cleaning --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header">
                                <h5>Data Peta Risiko Setelah Cleaning</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Unit</th>
                                            <th>IKU</th>
                                            <th>Judul</th>
                                            <th>Anggaran</th>
                                            <th>Skor Probabilitas</th>
                                            <th>Skor Dampak</th>
                                            <th>Uraian</th>
                                            <th>Resiko</th>
                                            <th>Pernyataan</th>
                                            <th>Pengendalian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($petaCleaneds as $index => $item)
                                            <tr>
                                                <td class="align-top">
                                                    {{ ($petaCleaneds->currentPage() - 1) * $petaCleaneds->perPage() + $index + 1 }}
                                                </td>
                                                <td class="align-top">{{ $item->nmUnit }}</td>
                                                <td class="align-top">{{ $item->iku }}</td>
                                                <td class="align-top">{{ $item->nmKegiatan }}</td>
                                                <td class="align-top">{{ $item->nilRabUsulan }}</td>
                                                <td class="align-top">{{ $item->probaBilitas }}</td>
                                                <td class="align-top">{{ $item->dampak }}</td>
                                                <td class="align-top">{{ $item->uraianDampak }}</td>
                                                <td class="align-top">{{ $item->Resiko }}</td>
                                                <td class="align-top">{{ $item->pernyataanRisiko }}</td>
                                                <td class="align-top">{{ $item->pengendalian }}</td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Hasil Cleaning belum Tersedia
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $petaCleaneds->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Transform --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header">
                                <h5>Data Peta Risiko Setelah Transform</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Unit</th>
                                            <th>IKU</th>
                                            <th>Judul</th>
                                            <th>Anggaran</th>
                                            <th>Skor Probabilitas</th>
                                            <th>Skor Dampak</th>
                                            <th>Uraian</th>
                                            <th>Resiko</th>
                                            <th>Pernyataan</th>
                                            <th>Pengendalian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($petaCleaneds as $index => $item)
                                            @php
                                                $transform = json_decode($item->preprocessing->transform, true);
                                            @endphp
                                            <tr>
                                                <td class="align-top">
                                                    {{ ($petaCleaneds->currentPage() - 1) * $petaCleaneds->perPage() + $index + 1 }}
                                                </td>
                                                <td class="align-top">{{ $item->nmUnit }}</td>
                                                <td class="align-top">{{ number_format($transform['iku'], 1) }}</td>
                                                <td class="align-top">{{ $item->nmKegiatan }}</td>
                                                <td class="align-top">{{ $item->nilRabUsulan }}</td>
                                                <td class="align-top">{{ number_format($transform['probaBilitas']) }}</td>
                                                <td class="align-top">{{ number_format($transform['dampak']) }}</td>
                                                <td class="align-top">{{ $item->uraianDampak }}</td>
                                                <td class="align-top">{{ $item->Resiko }}</td>
                                                <td class="align-top">{{ $item->pernyataanRisiko }}</td>
                                                <td class="align-top">{{ $item->pengendalian }}</td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Hasil Transform belum Tersedia
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $petaCleaneds->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Normalisasi --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header">
                                <h5>Data Peta Risiko Setelah Normalisasi</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Unit</th>
                                            <th>IKU</th>
                                            <th>Judul</th>
                                            <th>Anggaran</th>
                                            <th>Tingkat Risiko</th>
                                            <th>Uraian</th>
                                            <th>Resiko</th>
                                            <th>Pernyataan</th>
                                            <th>Pengendalian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($petaCleaneds as $index => $item)
                                            @php
                                                $normalisasi = json_decode($item->preprocessing->normalisasi, true);
                                            @endphp
                                            <tr>
                                                <td class="align-top">
                                                    {{ ($petaCleaneds->currentPage() - 1) * $petaCleaneds->perPage() + $index + 1 }}
                                                </td>
                                                <td class="align-top">{{ $item->nmUnit }}</td>
                                                <td class="align-top">{{ number_format($normalisasi['skor_iku'], 10) }}
                                                </td>
                                                <td class="align-top">{{ $item->nmKegiatan }}</td>
                                                <td class="align-top">{{ number_format($normalisasi['anggaran'], 10) }}
                                                </td>
                                                <td class="align-top">
                                                    {{ number_format($normalisasi['tingkat_risiko'], 10) }}</td>

                                                <td class="align-top">{{ $item->uraianDampak }}</td>
                                                <td class="align-top">{{ $item->Resiko }}</td>
                                                <td class="align-top">{{ $item->pernyataanRisiko }}</td>
                                                <td class="align-top">{{ $item->pengendalian }}</td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Hasil Normalisasi belum Tersedia
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $petaCleaneds->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Hasil Cluster --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header">
                                <h5>Hasil Cluster Peta Risiko</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Unit</th>
                                            <th>IKU</th>
                                            <th>Judul</th>
                                            <th>Anggaran</th>
                                            <th>Skor Probabilitas</th>
                                            <th>Skor Dampak</th>
                                            <th>Uraian</th>
                                            <th>Resiko</th>
                                            <th>Pernyataan</th>
                                            <th>Pengendalian</th>
                                            <th>Cluster</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($petaCleaneds as $index => $item)
                                            @php
                                                $transform = json_decode($item->preprocessing->transform, true);
                                            @endphp
                                            <tr>
                                                <td class="align-top">
                                                    {{ ($petaCleaneds->currentPage() - 1) * $petaCleaneds->perPage() + $index + 1 }}
                                                </td>
                                                <td class="align-top">{{ $item->nmUnit }}</td>
                                                <td class="align-top">{{ $item->iku }}
                                                </td>
                                                <td class="align-top">{{ $item->nmKegiatan }}</td>
                                                <td class="align-top">{{ $item->nilRabUsulan }}
                                                </td>
                                                <td class="align-top">{{ number_format($transform['probaBilitas']) }}
                                                </td>
                                                <td class="align-top">{{ number_format($transform['dampak']) }}
                                                </td>

                                                <td class="align-top">{{ $item->uraianDampak }}</td>
                                                <td class="align-top">{{ $item->Resiko }}</td>
                                                <td class="align-top">{{ $item->pernyataanRisiko }}</td>
                                                <td class="align-top">{{ $item->pengendalian }}</td>
                                                <td class="align-top text-center">{{ $item->cluster->cluster }}</td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Hasil Cluster Peta Risio belum Tersedia
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $petaCleaneds->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Interpretasi Cluster --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header">
                                <h5>Interpretasi Cluster</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Cluster</th>
                                            <th>Centroid Skor IKU</th>
                                            <th>Centroid Skor Anggaran</th>
                                            <th>Centroid Skor Tingkat Risiko</th>
                                            <th>Interpretasi</th>
                                            <th>Rekomendasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clusteringRun->interpretasi as $interpret)
                                            @php
                                                $centroid = $interpret->centroid;
                                            @endphp
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $clusteringRun->nama_file }}</td>
                                                <td>Cluster {{ $interpret->cluster }}</td>
                                                <td>{{ number_format($centroid['skor_iku']) }}</td>
                                                <td>{{ number_format($centroid['anggaran']) }}</td>
                                                <td>{{ number_format($centroid['tingkat_risiko']) }}</td>
                                                <td>{{ $interpret->interpretasi }}</td>
                                                <td>—</td> {{-- Jika nanti ada rekomendasi bisa ditambahkan di sini --}}
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <div class="alert alert-danger text-center mb-0">
                                                        Data Interpretasi Cluster belum tersedia.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
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
