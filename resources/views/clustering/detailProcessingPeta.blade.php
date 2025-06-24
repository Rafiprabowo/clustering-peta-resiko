@extends('layout.app')
@section('title', 'Detail Preprocessing Risiko')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <a href="{{ url()->previous() }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Detail Preprocessing Risiko</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Judul Kegiatan: {{ $petaRisiko->nmKegiatan }}</h4>
                    </div>
                    <div class="card-body">

                        {{-- Sebelum Preprocessing --}}
                        <h5 class="mb-3">Sebelum Preprocessing</h5>
                        <table class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 30%">Kolom</th>
                                    <th>Isi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Anggaran</td>
                                    <td>{{ $petaRisiko->nilRabUsulan }}</td>
                                </tr>
                                <tr>
                                    <td>Pernyataan Risiko</td>
                                    <td>{{ $petaRisiko->pernyataanRisiko }}</td>
                                </tr>
                                <tr>
                                    <td>Kategori Risiko</td>
                                    <td>{{ $petaRisiko->Resiko }}</td>
                                </tr>
                                <tr>
                                    <td>Uraian Dampak</td>
                                    <td>{{ $petaRisiko->uraianDampak }}</td>
                                </tr>
                                <tr>
                                    <td>Pengendalian</td>
                                    <td>{{ $petaRisiko->pengendalian }}</td>
                                </tr>
                                <tr>
                                    <td>Dampak</td>
                                    <td>{{ $petaRisiko->dampak }}</td>
                                </tr>
                                <tr>
                                    <td>Probabilitas</td>
                                    <td>{{ $petaRisiko->probaBilitas }}</td>
                                </tr>
                            </tbody>
                        </table>

                        {{-- Setelah Preprocessing --}}
                        <h5 class="mt-5 mb-3">Setelah Preprocessing</h5>
                        @if ($petaRisiko->processing)
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Kolom</th>
                                        <th>Isi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Skor Dampak</td>
                                        <td>{{ $petaRisiko->processing->skor_dampak }}</td>
                                    </tr>
                                    <tr>
                                        <td>Skor Kemungkinan</td>
                                        <td>{{ $petaRisiko->processing->skor_kemungkinan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tingkat Risiko</td>
                                        <td>{{ $petaRisiko->processing->tingkat_risiko }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning">Data preprocessing belum tersedia.</div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
