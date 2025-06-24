@extends('layout.app')
@section('title', "Detail Peta Risiko $decodedUnit ($tahun)")

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <a href="{{ url()->previous() }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Detail Peta Risiko {{ $decodedUnit }} ({{ $tahun }})</h1>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        @if ($petaRisikos->isEmpty())
                            <div class="alert alert-warning">Tidak ada data.</div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Register</th>
                                        <th>Judul</th>
                                        <th>IKU</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($petaRisikos as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->idUsulan }}</td>
                                            <td>{{ $data->nmKegiatan }}</td>
                                            <td>{{ $data->iku }}</td>
                                            <td class="text-center">
                                                {{-- Tombol Detail Identifikasi Risiko --}}
                                                <a href="{{ route('detailPetaRisikoById', ['id' => $data->id]) }}"
                                                    class="btn fa-solid fa-list bg-success p-2 text-white"
                                                    data-toggle="tooltip" title="Detail Identifikasi Risiko">
                                                </a>

                                                {{-- Tombol Detail Preprocessing --}}
                                                {{-- {{ route('', ['id' => $data->id]) }} --}}
                                                @if ($data->processing)
                                                    <a href="{{ route('detailProcessingPeta', ['id' => $data->id]) }}"
                                                        class="btn fa-solid fa-cogs bg-primary p-2 text-white"
                                                        data-toggle="tooltip" title="Lihat Hasil Preprocessing">
                                                    </a>
                                                @endif
                                                @if ($data->transformed)
                                                    <a href="{{ route('detailTransformPeta', ['id' => $data->id]) }}"
                                                        class="btn fa-solid fa-cogs bg-info p-2 text-white"
                                                        data-toggle="tooltip" title="Lihat Hasil Transformasi">
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
