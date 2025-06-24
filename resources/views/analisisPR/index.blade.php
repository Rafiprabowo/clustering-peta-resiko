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
                                <select id="selectYear" name="year" class="form-control" onchange="this.form.submit()">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>

                                {{-- <div class="input-group-append ml-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div> --}}
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
                                            <a href="{{ route('clustering.index') }}" class="btn btn-primary mb-1">
                                                <i class="fas fa-chart-simple"></i> Clustering
                                            </a>
                                        @endif

                                        <a href="{{ route('detailCluster') }}" class="btn btn-outline-success mb-1">Detail
                                            Cluster</a>

                                        <a href="{{ url('/analisis/petas/heatmap') }}"
                                            class="btn btn-md btn-primary mb-1">Heatmap Clusters</a>

                                        <a href="{{ route('pieChart') }}" class="btn btn-success mb-1">Visualisasi
                                            Clusters</a>

                                    </div>
                                </div>
                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Unit Kerja</th>
                                            @foreach ($interpretasiClusters as $cluster => $row)
                                                <th>
                                                    Cluster {{ $cluster }}<br>
                                                    <small class="text-muted">{{ $row->interpretasi }}</small>
                                                </th>
                                            @endforeach
                                            <th>Total</th>
                                            <th>Tahun</th>
                                            <th>Detail</th>
                                            <th>Grafik Cluster</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse ($clusteredByUnitPaginated as $unit)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $unit['unit'] }}</td>
                                                @foreach ($interpretasiClusters as $cluster => $row)
                                                    @php
                                                        $info = $unit['clusters'][$cluster] ?? [
                                                            'label' => '-',
                                                            'jumlah' => 0,
                                                        ];
                                                    @endphp
                                                    <td>
                                                        {{ $info['jumlah'] }}<br>
                                                    </td>
                                                @endforeach

                                                <td>{{ $unit['total'] }}</td>
                                                <td>{{ $selectedYear }}</td>
                                                <td>
                                                    <a href="{{ route('analisisPr.detailUnitKerja', ['unit' => $unit['unit'], 'tahun' => $selectedYear]) }}"
                                                        class="btn btn-success mb-1">Lihat Detail</a>

                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-primary mb-1">Lihat Grafik</a>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse

                                    </tbody>

                                </table>
                                <div class="d-flex justify-content-start">
                                    {{ $clusteredByUnitPaginated->links('pagination::bootstrap-4') }}
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
    document.addEventListener('DOMContentLoaded', function(){
        const yearSelect = document.querySelector('[name="year"]')
        const fileSelect = document.querySelector('[name="file"]')

        yearSelect.addEventListener('change', function(){
            const year = this.value;

            fetch(`/get-files-by-year?year=${year}`)
                .then(res => res.json())
                .then(files =>{
                    fileSelect.innerHTML = '<option value="">-- Pilih File --</option>';
                    files.forEach(file => {
                        const option = document.createElement('option');
                        option.value = file
                        option.textContent = file;
                        fileSelect.appendChild(option);
                    });
                })
        })
    })
</script>
@endpush --}}
