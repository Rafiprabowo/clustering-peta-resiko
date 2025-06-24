@extends('layout.app')
@section('title', 'Detail Identifikasi Risiko ')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <a href="{{ url()->previous() }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Detail Identifikasi Risiko </h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Judul : {{ $petaRisiko->nmKegiatan }}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>

                                <tr>
                                    <th>Anggaran</th>
                                    <td>{{ $petaRisiko->nilRabUsulan }}</td>
                                </tr>
                                <tr>
                                    <th>Pernyataan Risiko</th>
                                    <td>{{ $petaRisiko->pernyataanRisiko }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori Risiko</th>
                                    <td>{{ $petaRisiko->Resiko }}</td>
                                </tr>
                                <tr>
                                    <th>Uraian Dampak</th>
                                    <td>{{ $petaRisiko->uraianDampak }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pencapaian</th>
                                    <td>{{ $petaRisiko->pengendalian }}</td>
                                </tr>
                                <tr>
                                    <th>Dampak</th>
                                    <td>{{ $petaRisiko->dampak }}</td>
                                </tr>
                                <tr>
                                    <th>Probabilitas</th>
                                    <td>{{ $petaRisiko->probaBilitas }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
