@extends('layout.app')
@section('title', 'Detail Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ route('analisisPr.index') }}" class="mr-3"><i class="fas fa-arrow-left"
                        style="font-size: 1.3rem"></i></a>
                <h1>Detail Clustering </h1>
            </div>
            <div class="section-body">
                <h4 class="tittle-1">
                    <span class="span0">Nama File : {{ $clusteringRun->nama_file }}</span>
                    {{-- <span class="span1">{{ $jenis }}</span> --}}
                </h4>

                {{-- Cleaning --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Data Peta Risiko</h5>
                                <span class="badge badge-primary">Total: {{ $totalPetaRisiko }}</span>
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


                {{-- Interpretasi Cluster --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-header">
                                <h5>Grafik Centroid </h5>
                            </div>
                            <div class="card-body">
                                @livewire('interpretasi-chart', ['clusteringRunId' => $clusteringRun->id])
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
