@extends('layout.app')
@section('title', 'Riwayat Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url('/') }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Riwayat Clustering</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Total Data</th>
                                            <th>Data Bersih</th>
                                            <th>Data Dibuang</th>
                                            <th>Score</th>
                                            <th>Waktu</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayats as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->nama_file }}</td>
                                                <td class="text-center">{{ ($item->data_bersih + $item->data_dibuang) }}</td>
                                                <td class="text-center">{{ $item->data_bersih }}</td>
                                                <td class="text-center">{{ $item->data_dibuang }}</td>
                                                <td class="text-center">{{ $item->score }}</td>
                                                <td class="text-center">{{ $item->created_at }}</td>

                                                <td class="text-center">
                                                    <form action="{{ route('clustering.delete', $item->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus data clustering ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger py-1 px-2"
                                                            data-toggle="tooltip" title="Hapus Data">
                                                            <i class="fas fa-trash-alt fa-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">
                                                    <div class="alert alert-danger m-0">
                                                           Data Riwayat Clustering belum Tersedia
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $riwayats->links('pagination::bootstrap-4') }}
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
