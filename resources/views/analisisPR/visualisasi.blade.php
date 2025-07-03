@extends('layout.app')
@section('title', 'Visualisasi Cluster')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url('/') }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Visualisasi Hasil Clustering</h1>
            </div>
            <div class="section-body">
                @livewire('visualisasi-cluster')
            </div>
        </section>
    </div>
@endsection
