@extends('layout.app')
@section('title', 'Detail Analisis Peta Risiko Unit Kerja')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Rincian {{ $unit }} {{ $year }} </h1>
            </div>
            <div class="section-body">
                @forelse ($groupedByCluster as $cluster => $data )
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ url()->current() }}" method="GET"">
                                <input type="hidden" name="unit" value="{{ $unit }}">
                                <input type="hidden" name="tahun" value="{{ $year }}">
                                <input type="hidden" name="cluster" value="{{ $cluster }}">

                                <div class="input-group">
                                    <input type="text" name="q_{{ $cluster }}" class="form-control mr-2"
                                        placeholder="Search: Masukkan Judul" value="{{ request('q_' . $cluster) }}">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if (request('q_' . $cluster))
                                        <a href="{{ url()->current() }}?unit={{ $unit }}&tahun={{ $year }}"
                                            class="btn btn-default">
                                            <i class="fas fa-xmark"></i>
                                        </a>
                                    @endif

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Cluster {{ $cluster }} - {{ $data['interpretasi'] }}</h5>
                                    <span class="badge badge-light">{{ $data['paginator']->total() }} kegiatan</span>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>ID Usulan</th>
                                                <th>Judul</th>
                                                <th>IKU</th>
                                                <th>Anggaran</th>
                                                <th>Pernyataan Risiko</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['paginator'] as $index => $item)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $index + 1 + ($data['paginator']->currentPage() - 1) * $data['paginator']->perPage() }}
                                                    </td>
                                                    <td>{{ $item->cleaned->idUsulan }}</td>
                                                    <td>{{ $item->cleaned->nmKegiatan }}</td>
                                                    <td>{{ $item->cleaned->iku }}</td>
                                                    <td>{{ $item->cleaned->nilRabUsulan }}</td>
                                                    <td>{{ $item->cleaned->pernyataanRisiko }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {{-- Pagination untuk masing-masing cluster --}}
                                    <div class="d-flex justify-content-start">
                                        {{ $data['paginator']->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Tidak ada data analisis peta risiko untuk unit kerja <strong>{{ $unit }}</strong> pada
                        tahun <strong>{{ $year }}</strong>.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection
