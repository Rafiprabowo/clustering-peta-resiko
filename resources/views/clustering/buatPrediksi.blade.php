@extends('layout.app')
@section('title', 'Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Clustering</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <form action="{{ url('/clustering/prediksi') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="">Pilih File</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

                                    {{-- <button type="button" id="add-rtm" class="btn btn-md btn-success">Tambah RTM</button> --}}
                                    <button type="submit" class="btn btn-md btn-primary">SUBMIT</button>
                                    <button type="reset" class="btn btn-md btn-warning">RESET</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
