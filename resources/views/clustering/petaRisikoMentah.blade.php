@extends('layout.app')
@section('title', 'Data Peta Risiko')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3">
                    <i class="fas fa-arrow-left" style="font-size: 1.3rem"></i>
                </a>
                <h1>Data Peta Risiko </h1>
            </div>
            <div class="section-body">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <form action="{{ url('/clustering/data-peta-risiko') }}" method="GET">
                            <div class="input-group mb-2">
                                <select name="year" class="form-control">
                                    <option value="">-- Semua Tahun --</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- <select name="file" class="form-control ml-2">
                                    <option value="">-- Semua File --</option>
                                    @foreach ($fileNames as $file)
                                        <option value="{{ $file }}" {{ $file == $selectedFile ? 'selected' : '' }}>
                                            {{ $file }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                <div class="input-group-append ml-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


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

                                        <a href="{{ url('/clustering/visulisasi') }}"
                                            class="btn btn-md btn-primary mb-1">Visualisasi Clusters</a>

                                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <a href="{{ url('/clustering/prediksi') }}"
                                                class="btn btn-outline-primary mb-1">
                                                <i class="fas fa-magnifying-glass-plus"></i> Buat Prediksi
                                            </a>
                                            <a href="{{ url('clustering/') }}" class="btn btn-primary mb-1">
                                                <i class="fas fa-chart-simple"></i> Clustering
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Unit Kerja</th>
                                            <th>Total Kegiatan</th>
                                            <th>Tahun</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($unitKerjas as $index => $unit)
                                            <tr>
                                                <td>{{ ($unitKerjas->currentPage() - 1) * $unitKerjas->perPage() + $index + 1 }}
                                                </td>
                                                <td>{{ $unit->nmUnit }}</td>
                                                <td class="text-center">{{ $unit->total }}</td>
                                                <td class="text-center">{{ $unit->tahun }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('detailPetaRisikoPerUnitKerja', ['unit' => urlencode($unit->nmUnit), 'tahun' => $unit->tahun]) }}"
                                                        class="btn btn-success">Lihat Detail</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div class="alert alert-danger m-0">
                                                        Data Peta Risiko belum Tersedia.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                {{-- Pagination --}}
                                <div class="d-flex justify-content-start">
                                    {{ $unitKerjas->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
