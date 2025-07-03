@extends('layout.app')
@section('title', 'Riwayat Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ route('analisisPr.index') }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Riwayat Clustering</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        {{-- @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <a href="{{ route('petas.create') }}" class="btn btn-md btn-success mb-1">TAMBAH
                                                PETA</a>
                                        @endif --}}

                                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <a href="{{ url('/clustering/prediksi') }}"
                                                class="btn btn-outline-primary mb-1">
                                                <i class="fas fa-magnifying-glass-plus"></i> Buat Prediksi
                                            </a>

                                            <a href="{{ url('/analisis/petas') }}" class="btn btn-primary mb-1">
                                                Analisis Peta Risiko
                                            </a>
                                        @endif

                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Metode</th>
                                            <th>Akurasi</th>
                                            <th>Waktu Clustering</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clusteringRuns as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->nama_file }}</td>
                                                <td class="text-center">{{ $item->metode }}</td>
                                                <td class="text-center">{{ $item->silhouette_score }}</td>
                                                <td class="text-center">{{ $item->created_at }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('clustering.detail', ['id' => $item->id]) }}"
                                                        class="btn btn-success p-2 text-white" data-toggle="tooltip"
                                                        title="Detail Clustering">
                                                        <i class="fas fa-project-diagram"></i>
                                                    </a>
                                                    <a href="{{ route('clustering.detailVisualisasi', ['id' => $item->id]) }}"
                                                        class="btn btn-primary p-2 text-white" data-toggle="tooltip"
                                                        title="Visualisasi Hasil Clustering">
                                                        <i class="fas fa-chart-simple"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Clustering Peta Risiko belum Tersedia
                                            </div>
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
