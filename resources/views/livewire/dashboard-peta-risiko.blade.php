@push('style')
    <style>
        .table thead th {
            border: 1px solid #dee2e6 !important;
            vertical-align: middle;
            text-align: center;
        }
    </style>
@endpush

<div>


    <div class="row align-items-end">

        {{-- Filter Tahun --}}
        <div class="col-md-4">
            <label for="tahunTerpilih">Filter Tahun:</label>
            <select class="form-control" wire:model="tahunTerpilih" id="tahunTerpilih">
                <option value="">-- Semua Tahun --</option>
                @foreach ($daftarTahun as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Clustering --}}
        <div class="col-md-4">
            <label for="clustering">Pilih File Peta Risiko:</label>
            <select class="form-control" wire:model="selectedClustering" id="clustering"
                {{ !$tahunTerpilih ? 'disabled' : '' }}>
                <option value="">-- Pilih File --</option>
                @foreach ($clusteringList as $id => $nama)
                    <option value="{{ $id }}">{{ $nama }}</option>
                @endforeach
            </select>
        </div>



        @if ($tahunTerpilih && $selectedClustering)
            {{-- Tombol Export --}}
            <div class="col text-right justify-content-center">
                @if ($selectedClustering)
                    <button wire:click="exportPdf" class="btn btn-danger mt-4">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                @endif
            </div>
        @endif
    </div>



    @if ($selectedClustering)

        {{-- Chart --}}
        <div class="row align-items-stretch">
            @if ($quickChartUrl)
                <div class="col-md-6 mb-4 h-100">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <h5 class="text-center">Jumlah Kegiatan di Tiap Cluster</h5>
                            <img src="{{ $quickChartUrl }}" alt="Pie Chart Cluster" class="img-fluid mt-3">
                        </div>
                    </div>
                </div>
            @endif

            @if ($ikuChartUrl)
                <div class="col-md-6 mb-4 h-100">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <h5 class="text-center">Jumlah IKU Tercapai di Tiap Cluster</h5>
                            <img src="{{ $ikuChartUrl }}" alt="Pie Chart IKU" class="img-fluid mt-3">
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Centroid Bar Chart --}}
        {{-- <div class="row">
            @foreach ($centroidCharts as $field => $chartUrl)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="{{ $chartUrl }}" alt="Chart {{ $field }}" class="img-fluid">
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}

        {{-- Rentang Nilai Asli --}}
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <strong>Rentang & Rata-rata Data Tiap Cluster</strong>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="align-middle text-center">Cluster</th>
                                    <th colspan="2" class="text-center">IKU</th>
                                    <th colspan="2" class="text-center">Anggaran</th>
                                    <th colspan="2" class="text-center">Tingkat Risiko</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Min - Max</th>
                                    <th class="text-center">Rata-rata</th>
                                    <th class="text-center">Min - Max</th>
                                    <th class="text-center">Rata-rata</th>
                                    <th class="text-center">Min - Max</th>
                                    <th class="text-center">Rata-rata</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clusterStats as $stat)
                                    <tr>
                                        <td class="text-center">Cluster {{ $stat['cluster'] }}</td>
                                        <td class="text-center">{{ $stat['min_iku'] }} - {{ $stat['max_iku'] }}</td>
                                        <td class="text-center">{{ $stat['avg_iku'] }}</td>
                                        <td class="text-center">Rp {{ number_format($stat['min_anggaran']) }} - Rp
                                            {{ number_format($stat['max_anggaran']) }}</td>
                                        <td class="text-center">Rp {{ number_format($stat['avg_anggaran']) }}</td>
                                        <td class="text-center">{{ $stat['min_risiko'] }} - {{ $stat['max_risiko'] }}
                                        </td>
                                        <td class="text-center">{{ $stat['avg_risiko'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <strong>Daftar IKU Tiap Cluster</strong>
                    </div>
                    <div class="card-body">
                        @foreach ($ikuPerCluster as $clusterId => $ikus)
                            <div class="mb-4">
                                <h5 class="text-primary">Cluster {{ $clusterId }}</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Kode IKU</th>
                                                <th>Total Kegiatan</th>
                                                <th>ID Usulan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (collect($ikus)->sortKeys() as $iku => $detail)
                                                <tr>
                                                    <td>{{ $iku }}</td>
                                                    <td>{{ $detail['total'] }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary"
                                                            wire:click="$emit('bukaModal', {{ $clusterId }}, '{{ $iku }}')">
                                                            Lihat
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-start mt-3">
            <em>Silakan pilih Tahun dan File Peta Risiko terlebih dahulu.</em>
        </div>
    @endif
</div>

@push('modals')
    <div wire:ignore.self class="modal fade" id="modalUsulan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsulanTitle">Detail ID Usulan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modalUsulanBody">
                    <div class="text-center text-muted">Memuat...</div>
                </div>
            </div>
        </div>
    </div>
@endpush



@push('scripts')
    <script>
        window.addEventListener('show-modal', event => {
            const {
                title,
                data
            } = event.detail;
            $('#modalUsulanTitle').text(title);

            const body = $('#modalUsulanBody');
            body.empty();

            function klasifikasiRisiko(nilai) {
                if (nilai >= 1 && nilai <= 4) return "VERY LOW";
                else if (nilai >= 5 && nilai <= 8) return "LOW";
                else if (nilai >= 9 && nilai <= 12) return "MIDDLE";
                else if (nilai >= 13 && nilai <= 19) return "HIGH";
                else if (nilai >= 20 && nilai <= 25) return "VERY HIGH";
                else return "Tidak Valid";
            }

            function formatAngka(nilai) {
                return new Intl.NumberFormat('id-ID').format(nilai);
            }


            if (data.length > 0) {
                const table = $(`
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Usulan</th>
                            <th>Nama Unit</th>
                            <th>Nama Kegiatan</th>
                            <th>Nilai Anggaran</th>
                            <th>Skor Dampak</th>
                            <th>Skor Probabilitas</th>
                            <th>Tingkat Risiko</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            `);


                data.forEach((item, index) => {
                    table.find('tbody').append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.id_usulan}</td>
                    <td>${item.nama_unit}</td>
                    <td>${item.nama_kegiatan}</td>
                    <td>${formatAngka(item.nil_rab_usulan)}</td>
                    <td>${item.dampak_numerik}</td>
                    <td>${item.probabilitas_numerik}</td>
                    <td>${item.tingkat_risiko} (${klasifikasiRisiko(item.tingkat_risiko)})</td>
                </tr>
            `);
                });

                body.append(table);
            } else {
                body.append('<div class="text-center text-muted">Tidak ada data.</div>');
            }

            $('#modalUsulan').modal('show');
        });
    </script>
@endpush
