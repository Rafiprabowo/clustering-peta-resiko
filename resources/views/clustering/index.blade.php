@extends('layout.app')
@section('title', 'Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Clustering</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Tahun</th>
                                            <th>Metode</th>
                                            <th>Akurasi</th>
                                            <th>Tanggal Clustering</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clusteringRuns as $data)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $data->nama_file }}</td>
                                                <td class="text-center">{{ $data->tahun }}</td>
                                                <td class="text-center">{{ $data->metode }}</td>
                                                <td class="text-center">{{ $data->silhouette_score }}</td>
                                                <td class="text-center">{{ $data->created_at }}</td>
                                                <td><a href="">Lihat Detail</a></td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Riwayat Clustering belum Tersedia
                                            </div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $clusteringRuns->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
