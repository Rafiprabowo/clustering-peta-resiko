@extends('layout.app')
@section('title', 'Preprocessing')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Clustering Peta Risiko</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <a href="{{ route('petas.create') }}" class="btn btn-md btn-success mb-1">TAMBAH
                                                PETA</a>
                                        @endif

                                        <a href="{{ url('/clustering/visulisasi') }}" class="btn btn-md btn-primary mb-1">Visualisasi Clusters</a>

                                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <a href="{{ url('/clustering/prediksi') }}" class="btn btn-outline-primary mb-1">
                                                <i class="fas fa-magnifying-glass-plus"></i> Buat Prediksi
                                            </a>
                                             <a href="{{ url('clustering/') }}" class="btn btn-primary mb-1">
                                                <i class="fas fa-chart-simple"></i> Clustering
                                            </a>

                                        @endif
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Kode Resgister</th>
                                            <th>Judul</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Lorem, ipsum dolor.</td>
                                            <td>Lorem, ipsum dolor.</td>
                                            <td>Lorem, ipsum dolor.</td>
                                            <td>Lorem, ipsum dolor.</td>
                                        </tr>
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
