@extends('layout.app')
@section('title', "Detail Cluster Peta Risiko $decodedUnit ($tahun)")

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Detail Cluster Peta Risiko {{ $decodedUnit }} ({{ $tahun }}) </h1>
            </div>
            <div class="section-body">

                {{-- Table Cluster --}}
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table table-bordered mt-2">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Register</th>
                                    <th>Judul</th>
                                    <th>Cluster</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petaRisikos as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->idUsulan }}</td>
                                        <td>{{ $data->nmKegiatan }}</td>
                                        <td>{{ $data->cluster->cluster }}</td>
                                        <td>
                                            <a href="">Identifikasi Risiko</a>
                                            <a href="">Interpretasi Cluster</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-start">
                            {{-- {{ $paginatedData->links('pagination::bootstrap-4') }} --}}
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
