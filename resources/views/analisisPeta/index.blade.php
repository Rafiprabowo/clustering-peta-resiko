@extends('layout.app')
@section('title', 'Analisis Peta Risiko')

@section('main')

    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="#" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Analisis Peta Risiko</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <livewire:analisis-peta-risiko />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
