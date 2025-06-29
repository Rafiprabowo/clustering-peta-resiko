@extends('layout.app')
@section('title', 'Data Peta Risiko')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Data Peta Risiko</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
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
                                                <td>{{ ($petaCleaneds->currentPage() - 1) * $petaCleaneds->perPage() + $index + 1 }}
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
                                {{ $petaCleaneds->links('pagination::bootstrap-4') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
