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
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <a href="{{ route('clustering-peta-risiko.prediksi') }}"
                                            class="btn btn-outline-primary mb-1">
                                            <i class="fas fa-magnifying-glass-plus"></i> Buat Prediksi
                                        </a>
                                    </div>
                                </div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama File</th>
                                            <th>Metode</th>
                                            <th>Akurasi</th>
                                            <th>Waktu Clustering</th>
                                            <th>Download Hasil</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($clusteringRuns as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->nama_file }}</td>
                                                <td class="text-center">{{ $item->metode }}</td>
                                                <td class="text-center">{{ $item->silhouette_score }}</td>
                                                <td class="text-center">{{ $item->created_at }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('clustering.download', $item->id) }}"
                                                        class="btn btn-sm btn-danger py-1 px-2 text-white"
                                                        data-toggle="tooltip" title="Download PDF">
                                                        Export <i class="fas fa-file-pdf"></i>
                                                    </a>

                                                </td>
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
                                                        Data Clustering Peta Risiko belum Tersedia
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Hapus Berhasil -->
    <div class="modal fade" id="hapusBerhasilModal" tabindex="-1" role="dialog" aria-labelledby="hapusBerhasilLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="hapusBerhasilLabel">Berhasil</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Data clustering berhasil dihapus!
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery & Bootstrap Bundle (if not already loaded) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    @if (session('success'))
        <script>
            $(document).ready(function() {
                $('#hapusBerhasilModal').modal('show');
            });
        </script>
    @endif
@endsection
