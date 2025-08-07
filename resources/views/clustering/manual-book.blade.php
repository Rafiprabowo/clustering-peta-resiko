@extends('layout.app')
@section('title', 'Manual Book')

@section('main')

<div class="main-content">
    <section class="section">
        <div class="section-header d-flex align-items-center">
            <a href="#" class="mr-3">
                <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
            </a>
            <h1>Panduan Penggunaan Sistem</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow rounded">
                        <div class="card-body">
                            <p>
                                Silakan unduh dokumen manual book berikut untuk mengetahui panduan penggunaan sistem
                                <strong>Pengembangan Model Clustering untuk Analisis Peta Risiko pada Tata Kelola Manajemen Non-Akademik</strong>.
                            </p>
                            <a href="{{ route('download.panduan-pengguna') }}" class="btn btn-outline-primary" target="_blank">
                                Unduh Manual Book (PDF)
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
