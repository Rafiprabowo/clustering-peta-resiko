@extends('layout.app')
@section('title', 'Visualisasi Cluster')
@section('main')
    {{-- <style>
        td {
            color: white
        }
    </style> --}}
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex align-items-center">
                <a href="{{ url()->previous() }}" class="mr-3"><i class="fas fa-arrow-left" style="font-size: 1.3rem"></i></a>
                <h1>Visualisasi Cluster</h1>
            </div>
            <div class="section-body">
                <h4 class="tittle-1">
                    <span class="span0">File : {{ $clusteringRun->nama_file }}</span>
                </h4>

                <!-- Filter Cluster -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <form action="{{ route('clustering.detailVisualisasi', ['id' => $clusteringRun->id]) }}"
                            method="GET">
                            <div class="input-group mb-2">
                                <select id="selectCluster" name="cluster" class="form-control mr-2">
                                    <option value="">Pilih Cluster</option>
                                    @foreach ($clusters as $cluster)
                                        <option value="{{ $cluster }}"
                                            {{ (string) $cluster === (string) $selectedCluster ? 'selected' : '' }}>
                                            Cluster {{ $cluster }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="input-group-append ml-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row ">
                    <!-- Tabel -->
                    <div class="col-md-9">
                        <div class="card shadow h-100">

                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Tabel Cluster</h5>
                                <span class="badge badge-primary">
                                    Total IKU
                                    {{ $selectedCluster !== null
                                        ? 'Cluster ' . $selectedCluster . ': ' . ($totalIkuByCluster[$selectedCluster] ?? 0)
                                        : 'Global: ' . $totalIkuGlobal }}
                                </span>
                            </div>


                            <div class="card-body d-flex flex-column">
                                <table class="table table-bordered table-sm mb-4">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Kode IKU</th>
                                            <th>Uraian</th>
                                            <th>Total</th>
                                            <th>Kode Register</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $ikus = $selectedCluster !== null ? $ikusPaginated : $ikuGlobalPaginated;
                                        @endphp

                                        @forelse ($ikus as $kode => $item)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $ikus->firstItem() + $loop->index }}
                                                </td>
                                                <td>{{ $kode }}</td>
                                                <td>{{ $item['uraian'] }}</td>
                                                <td class="text-center">{{ $item['jumlah'] }}</td>
                                                <td>
                                                    {{ implode(', ', $item['idUsulan']) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada data</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $ikus->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="col-md-3">
                        <div class="card shadow h-100">
                            <div class="card-header">
                                <h5 class="text-center">Distribusi IKU</h5>
                            </div>
                            <div class="card-body d-flex flex-column justify-content-center">

                                <canvas id="ikuChart" style="max-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Chart Lengkap Tanpa Pagination --}}
                {{-- <div class="row mt-4">
                    <div class="col-md-6 offset-md-3">
                        <div class="card shadow">
                            <div class="card-header">
                                <h5 class="text-center">Distribusi IKU </h5>
                            </div>
                            <div class="card-body">
                                <canvas id="ikuChartFull" style="max-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div> --}}



            </div>
        </section>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // CHART 1: yang ditampilkan di tabel
            const ctx = document.getElementById('ikuChart').getContext('2d');
            const data = {
                labels: {!! json_encode($ikus->map(fn($item, $kode) => $kode)->values()) !!},
                datasets: [{
                    label: 'Total IKU',
                    data: {!! json_encode($ikus->map(fn($item) => $item['jumlah'])->values()) !!},
                    backgroundColor: [
                        '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0',
                        '#9966ff', '#ff9f40', '#00a65a', '#f39c12',
                        '#d81b60', '#3c8dbc', '#605ca8', '#39cccc'
                    ],
                    borderWidth: 1
                }]
            };
            new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.chart.data.datasets[0].data.reduce((a, b) => a +
                                        b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }

            });

            // CHART 2: seluruh data (tanpa pagination)
            // const ctxFull = document.getElementById('ikuChartFull').getContext('2d');
            // const dataFull = {
            //     labels: {!! json_encode($ikusFull->map(fn($item, $kode) => $kode)->values()) !!},
            //     datasets: [{
            //         label: 'Total IKU (All)',
            //         data: {!! json_encode($ikusFull->map(fn($item) => $item['jumlah'])->values()) !!},
            //         backgroundColor: [
            //             '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0',
            //             '#9966ff', '#ff9f40', '#00a65a', '#f39c12',
            //             '#d81b60', '#3c8dbc', '#605ca8', '#39cccc'
            //         ],
            //         borderWidth: 1
            //     }]
            // };
            // new Chart(ctxFull, {
            //     type: 'doughnut',
            //     data: dataFull,
            //     options: {
            //         responsive: true,
            //         plugins: {
            //             legend: {
            //                 position: 'bottom'
            //             },
            //             tooltip: {
            //                 callbacks: {
            //                     label: function(context) {
            //                         let label = context.label || '';
            //                         let value = context.raw || 0;
            //                         return `${label}: ${value}`;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // });
        });
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ambil total dari backend (global atau per cluster)
        const totalIku =
            {{ $selectedCluster !== null ? $totalIkuByCluster[$selectedCluster] ?? 1 : $totalIkuGlobal }};

        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('ikuChart').getContext('2d');
            const data = {
                labels: {!! json_encode($ikus->map(fn($item, $kode) => $kode)->values()) !!},
                datasets: [{
                    label: 'Total IKU',
                    data: {!! json_encode($ikus->map(fn($item) => $item['jumlah'])->values()) !!},
                    backgroundColor: [
                        '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0',
                        '#9966ff', '#ff9f40', '#00a65a', '#f39c12',
                        '#d81b60', '#3c8dbc', '#605ca8', '#39cccc'
                    ],
                    borderWidth: 1
                }]
            };

            new Chart(ctx, {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let percentage = ((value / totalIku) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>


@endsection
