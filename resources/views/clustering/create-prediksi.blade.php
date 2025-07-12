@extends('layout.app')
@section('title', 'Clustering')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="#" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Clustering</h1>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">

                                <form action="{{ route('clustering.store') }}" method="POST"
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

@push('scripts')
    <!-- jQuery dan Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    {{-- <style>
        .toastify-center {
            left: 50% !important;
            transform: translateX(-50%) !important;
        }
    </style> --}}

    <script>
        $(document).ready(function() {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 4000,
                    gravity: "top", // tetap top
                    position: "center", // pakai center agar class di bawah berlaku
                    backgroundColor: "#28a745",
                    // className: "toastify-center",
                    close: true,
                    stopOnFocus: true
                }).showToast();
            @elseif (session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 4000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#dc3545",
                    // className: "toastify-center",
                    close: true,
                    stopOnFocus: true
                }).showToast();
            @endif
        });
    </script>
@endpush
