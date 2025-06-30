@extends('layout.app')
@section('title', 'Hasil Analisis Peta Risiko')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Hasil Analisis Peta Risiko {{ $unit }}</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 shadow rounded">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Cluster</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($analisisPetas as $index => $item)
                                            <tr>
                                                <td class="text-center">{{ ($analisisPetas->currentPage() - 1) * $analisisPetas->perPage() + $index + 1 }}
                                                </td>
                                                <td>{{ $item->nmKegiatan }}</td>
                                                <td class="text-center">
                                                    {{ $item->cluster->cluster ?? '-' }}
                                                    {{-- ({{ $item->cluster && $item->cluster->interpretasi ? $item->cluster->interpretasi->interpretasi : '-' }}) --}}
                                                </td>

                                                <td class="text-center">
                                                    <a href="{{ route('analisisPr.detailPR', ['id' => $item->id]) }}"
                                                        class="btn fa-solid fa-list bg-success p-2 text-white"
                                                        data-toggle="tooltip" title="Detail Dokumen"></a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data tersedia</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                {{ $analisisPetas->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
