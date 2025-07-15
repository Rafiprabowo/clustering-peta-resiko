@extends('layout.app')
@section('title', 'List Dataset')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>List Dataset</h1>
            </div>
            <div class="section-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                 <div class="row">
                                    <div class="col-md-6 mb-1">
                                        {{-- @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <a href="{{ route('petas.create') }}" class="btn btn-md btn-success mb-1">TAMBAH
                                                PETA</a>
                                        @endif --}}

                                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)

                                            <a href="{{ route('datasetPetaRisiko.import.form') }}" class="btn btn-success mb-1">
                                                <i class="fas fa-file-excel"></i> Import Dataset
                                            </a>

                                        @endif
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama File</th>
                                            <th>Jumlah Data</th>
                                            <th>Waktu Upload</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayat as $file)
                                            <tr>
                                                <td>{{ $file->nama_file }}</td>
                                                <td>{{ $file->jumlah_data }}</td>
                                                <td>{{ $file->uploaded_at }}</td>
                                                <td>
                                                    <form method="POST" action="{{ route('datasetPetaRisiko.delete.byfilename') }}"
                                                        onsubmit="return confirm('Yakin hapus semua data dari file ini?')">
                                                        @csrf
                                                        <input type="hidden" name="nama_file"
                                                            value="{{ $file->nama_file }}">
                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                    {{-- <a href="{{ route('peta.export', $file->nama_file) }}"
                                                        class="btn btn-sm btn-success">Export</a> --}}

                                                    {{-- <form method="POST"
                                                        action="{{ route('peta.send.api', $file->nama_file) }}"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button class="btn btn-sm btn-primary">Kirim ke API</button>
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                           <td colspan="4" class="text-center">
                                            Dataset belum tersedia
                                           </td>
                                        </tr>

                                        @endforelse

                                    </tbody>
                                </table>
                                {{ $riwayat->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        $(document).ready(function() {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 4000,
                    gravity: "top",
                    position: "center",
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
