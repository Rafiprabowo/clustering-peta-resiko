@extends('layout.app')
@section('title', 'Kuisoner')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="#" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Kuisioner</h1>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <p>
                                    Silakan mengisi kuisioner berikut untuk memberikan penilaian dan masukan terhadap sistem
                                    Analisis Peta Risiko ini.
                                </p>
                                <p>
                                    Klik tombol di bawah ini untuk mengisi kuisioner:
                                </p>
                                <a href="https://forms.gle/wWuZuz8BoTgKEyX47" class="btn btn-primary" target="_blank">
                                    Isi Kuisioner
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
