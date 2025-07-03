@extends('layout.app')
@section('title', 'Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ route('clustering-peta-risiko.index') }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Clustering</h1>
            </div>
            <div class="section-body">

                {{-- ALERT --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">

                                <form action="{{ route('clustering-peta-risiko.predict') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group">
                                        <label for="">Pilih File</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>

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
