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
                                    Untuk panduan lengkap penggunaan sistem clustering untuk analisis peta risiko, silakan lihat <strong>Manual Book</strong>
                                    melalui tautan berikut:
                                </p>
                                <a href="https://docs.google.com/document/d/19sI0De5QtZR5yA5XhSRZdEpUK5pPxzSSfmAD_wTY80o/edit?usp=sharing"
                                    target="_blank" class="btn btn-info">
                                    Lihat Manual Book
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
