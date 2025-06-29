@extends('layout.app')
@section('title', 'Detail Clustering')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Detail Clustering</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-header">
                                <ul class="nav nav-tabs" id="clusteringTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="data-awal-tab" data-toggle="tab" href="#data-awal"
                                            role="tab">Data Awal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="cleaning-tab" data-toggle="tab" href="#cleaning"
                                            role="tab">Cleaning</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="preprocessing-tab" data-toggle="tab" href="#preprocessing"
                                            role="tab">Preprocessing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="cluster-tab" data-toggle="tab" href="#cluster"
                                            role="tab">Cluster</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body tab-content" id="clusteringTabsContent">
                                <div class="tab-pane fade show active" id="data-awal" role="tabpanel">
                                    {{-- Tabel Data Awal --}}
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Unit Kerja</th>
                                                <th>Usulan Kegiatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($petaAwals as $index => $peta)
                                                <tr>
                                                    <td>{{ ($petaAwals->currentPage() - 1) * $petaAwals->perPage() + $index + 1 }}
                                                    </td>
                                                    <td>{{ $peta->nmUnit }}</td>
                                                    <td>{{ $peta->nmKegiatan }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('clustering.detailPR', ['id' => $peta->id]) }}"
                                                            class="btn fa-solid fa-list bg-success p-2 text-white"
                                                            data-toggle="tooltip" title="Detail Dokumen"></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Data kosong</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {{ $petaAwals->links('pagination::bootstrap-4') }}
                                </div>

                                <div class="tab-pane fade" id="cleaning" role="tabpanel">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Unit Kerja</th>
                                                <th>Usulan Kegiatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($petaCleaneds as $index => $peta)
                                                <tr>
                                                    <td>{{ ($petaCleaneds->currentPage() - 1) * $petaAwals->perPage() + $index + 1 }}
                                                    </td>
                                                    <td>{{ $peta->nmUnit }}</td>
                                                    <td>{{ $peta->nmKegiatan }}</td>
                                                    <td class="text-center">
                                                        <a href=""
                                                            class="btn fa-solid fa-list bg-success p-2 text-white"
                                                            data-toggle="tooltip" title="Detail Dokumen"></a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Data kosong</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    {}
                                </div>

                                <div class="tab-pane fade" id="preprocessing" role="tabpanel">
                                    <p>Konten Preprocessing di sini</p>
                                </div>

                                <div class="tab-pane fade" id="cluster" role="tabpanel">
                                    <p>Konten Cluster di sini</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
