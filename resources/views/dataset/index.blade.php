@extends('layout.app')
@section('title', 'Dataset')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url('/dataset') }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Kelola Dataset</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    {{-- Kolom Upload Dataset --}}
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Upload Dataset</h5>
                            </div>
                            <div class="card-body">
                                @livewire('upload-dataset-form')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Kolom Daftar Dataset --}}
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="mb-0">Daftar Dataset</h5>
                            </div>
                            <div class="card-body">
                                @livewire('dataset-list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
