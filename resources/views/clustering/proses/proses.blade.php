@extends('layout.app')
@section('title', 'Proses Clustering')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="#" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Clustering</h1>
            </div>
            @livewire('proses-clustering')
        </section>
    </div>
@endsection

