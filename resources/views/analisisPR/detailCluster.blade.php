@extends('layout.app')
@section('title', 'Detail Cluster')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Detail Cluster</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>No</th>
                                        <th>Cluster</th>
                                        <th>Centroid Skor IKU</th>
                                        <th>Centroid Skor Anggaran</th>
                                        <th>Centroid Skor Dampak</th>
                                        <th>Centroid Skor Kemungkinan</th>
                                        <th>Skor Bobot</th>
                                        <th>Label</th>
                                    </thead>
                                    <tbody>

                                        @forelse ($detailClusters ?? [] as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->cluster }}</td>
                                            <td>{{ $detail->skor_iku }}</td>
                                            <td>{{ $detail->anggaran }}</td>
                                            <td>{{ $detail->skor_dampak }}</td>
                                            <td>{{ $detail->skor_kemungkinan }}</td>
                                            <td>{{ $detail->prioritas_score }}</td>
                                            <td>{{ $detail->label }}</td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">
                                                    <div class="alert alert-danger m-0">
                                                        Data Detail Cluster Belum Tersedia.
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
