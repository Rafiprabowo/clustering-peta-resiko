@extends('layout.app')
@section('title', 'Detail Transformation Risiko')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <a href="{{ url()->previous() }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Detail Transformation Risiko</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Judul Kegiatan: {{ $petaRisiko->nmKegiatan }}</h4>
                    </div>
                    <div class="card-body">

                        {{-- Sebelum Pretransformed --}}
                        <h5 class="mb-3">Sebelum Transformasi</h5>
                        <table class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th style="width: 30%">Kolom</th>
                                    <th>Isi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>IKU</td>
                                    <td>{{ $petaRisiko->iku }}</td>
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

                        {{-- Setelah Pretransformed --}}
                        <h5 class="mt-5 mb-3">Setelah Transformation</h5>
                        @if ($petaRisiko->transformed)
                            <table class="table table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Kolom</th>
                                        <th>Isi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                        <td>Skor IKU</td>
                                        <td>{{ $petaRisiko->transformed->skor_iku }}</td>
                                    </tr>
                                    <tr>
                                        <td>Skor Dampak</td>
                                        <td>{{ $petaRisiko->transformed->skor_dampak }}</td>
                                    </tr>
                                    <tr>
                                        <td>Skor Kemungkinan</td>
                                        <td>{{ $petaRisiko->transformed->skor_kemungkinan }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td>Tingkat Risiko</td>
                                        <td>{{ $petaRisiko->transformed->tingkat_risiko }}</td>
                                    </tr> --}}
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning">Data transformation belum tersedia.</div>
                        @endif

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
