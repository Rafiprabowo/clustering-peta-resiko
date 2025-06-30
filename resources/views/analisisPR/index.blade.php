@extends('layout.app')
@section('title', 'Analisis Peta Risiko')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Analisis Peta Risiko</h1>
            </div>
            <div class="section-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form action="{{ url('/analisis/petas/') }}" method="GET">
                            <div class="input-group mb-2">
                                <select id="selectYear" name="tahun" class="form-control mr-2">
                                    <option value="">Pilih Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected': '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- <select id="selectFile" name="file" class="form-control">

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

                                        @if (auth()->user()->id_level == 1 || auth()->user()->id_level == 2)
                                            <a href="{{ url('/clustering/prediksi') }}"
                                                class="btn btn-outline-primary mb-1">
                                                <i class="fas fa-magnifying-glass-plus"></i> Buat Prediksi
                                            </a>
                                            <a href="{{ route('clustering.index', ['tahun' => $selectedYear]) }}" class="btn btn-primary mb-1">
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
                                            <th>Total</th>
                                            <th>Tahun</th>
                                            <th>File Excel</th>
                                            <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($jenisCount as $item)
                                            <tr>
                                                  <td class="text-center">{{ $loop->iteration + ($jenisCount->currentPage() - 1) * $jenisCount->perPage() }}</td>
                                                <td>{{ $item->nmUnit }}</td>
                                                <td class="text-center">{{ $item->total }}</td>
                                                <td class="text-center">{{ $item->tahun }}</td>
                                                <td class="text-center">{{ $item->nama_file }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('analisisPr.detailAnalisisPetaUnitKerja',
                                                    ['unit' => urlencode($item->nmUnit),
                                                    'tahun' => $item->tahun,
                                                    'file' => urlencode($item->nama_file)
                                                    ]) }}"
                                                    class="btn btn-success">Lihat Detail</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">
                                                Data Analisis Peta Risiko belum Tersedia
                                            </div>
                                        @endforelse

                                    </tbody>

                                </table>
                                <div class="d-flex justify-content-start">
                                    {{ $jenisCount->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
{{-- @push('scripts')
    <script>
        $('#selectYear').change(function() {
            let year = $(this).val();

            // Kosongkan select file saat tahun berubah
            $('#selectFile').html('<option value="">Loading...</option>');

            // Lakukan request
            $.ajax({
                url: '{{ url('/analisis/petas/get-files-by-year') }}', // Buat route ini nanti
                type: 'GET',
                data: {
                    year: year
                },
                success: function(data) {
                    console.log(data)
                    let options = '<option value="">Pilih File</option>';
                    if (data.length > 0) {
                        data.forEach(function(file) {
                            options += `<option value="${file.id}">${file.nama_file}</option>`;
                        });
                    } else {
                        options = '<option value="">Tidak ada file</option>';
                    }
                    $('#selectFile').html(options);
                },
                error: function() {
                    $('#selectFile').html('<option value="">Gagal memuat data</option>');
                }
            });
        });
    </script>
@endpush --}}
