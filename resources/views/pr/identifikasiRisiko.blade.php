@extends('layout.app')
@section('title', 'Identifikasi dan Analisis Risiko')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url('/petas') }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Identifikasi dan Analisis Risiko</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Unit Kerja</th>
                                            <th>Download Pdf</th>
                                            <th>Download Excel</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($jenis as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item }}</td>
                                                <td><a
                                                        href="{{ route('petas.exporPdfUnitKerja', ['jenis' => $item, 'tahun' => $tahun]) }}">Download
                                                        Pdf</a>

                                                </td>
                                                <td>
                                                    <a
                                                        href="{{ route('petas.exportExcelUnitKerja', ['jenis' => $item, 'tahun' => $tahun]) }}">Export
                                                        Excel</a>
                                                </td>

                                        @endforeach
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
