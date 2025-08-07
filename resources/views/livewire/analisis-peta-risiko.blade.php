<div>
    {{-- Filter Tahun dan File --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <label for="selectedYear">Pilih Tahun</label>
            <select wire:model="selectedYear" class="form-control">
                <option value="">-- Pilih Tahun --</option>
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        @if ($files && count($files))
            <div class="col-md-4">
                <label for="selectedFile">Pilih File Hasil Clustering</label>
                <select wire:model="selectedFile" class="form-control">
                    <option value="">-- Pilih File --</option>
                    @foreach ($files as $file)
                        <option value="{{ $file->id }}">
                            {{ $file->dataset->original_name }} - {{ $file->created_at->format('d M Y H:i') }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        @if ($selectedFile)
            <div class="col-md-4 text-right mt-4">
                <a href="{{ route('clustering.export.pdf', $selectedFile) }}"
                    class="btn btn-danger btn-sm ml-2 text-right">
                    <i class="fas fa-file-pdf me-1"></i> Export PDF
                </a>
            </div>
        @endif


    </div>

    @if (!empty($jumlahPerCluster))
        <div class="mt-4">
            <h5 class="text-center mb-3">Karakteristik Klaster</h5>
            <table class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th>Klaster</th>
                        <th>Rata-rata nilai IKU</th>
                        <th>Rata-rata nilai RAB usulan</th>
                        <th>Rata-rata tingkat risiko</th>
                        <th>Jumlah Data</th>
                        <th>Interpretasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jumlahPerCluster as $item)
                        <tr class="text-center">
                            <td>{{ $item['cluster'] }}</td>
                            <td>{{ $item['rata_iku'] }}</td>
                            <td>Rp{{ number_format($item['rata_rab'], 0, ',', '.') }}</td>
                            <td>{{ $item['rata_risiko'] }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td>{{ $item['label'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif




    @if (!empty($uniqueIkuPerCluster))
        <div class="mt-5">
            <h5 class="text-center mb-3">Tabel Indikator Kinerja Utama (IKU)</h5>
            <table class="table table-bordered table-striped">
                <thead class="text-center">
                    <tr>
                        <th>Klaster</th>
                        <th>IKU</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($uniqueIkuPerCluster as $item)
                        <tr>
                            <td class="text-center">{{ $item['cluster'] }}</td>
                            <td>{{ $item['ikus']->join(', ') }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    @endif


    <div class="mt-4">

        @if ($paginatedData->count())
            @if ($selectedFile)
                <h5 class="text-center">Tabel ID Usulan</h5>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Filter IKU</label>
                        <select wire:model="filterIku" class="form-control">
                            <option value="">Semua IKU</option>
                            @foreach ($ikuOptions as $iku)
                                <option value="{{ $iku }}">{{ $iku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Filter Label</label>
                        <select wire:model="filterLabel" class="form-control">
                            <option value="">Semua Label</option>
                            @foreach ($labelOptions as $label)
                                <option value="{{ $label }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div>
                            <label><strong>Total data: {{ $paginatedData->total() }}</strong></label>
                        </div>
                    </div>

                </div>

            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>ID Usulan</th>
                        <th>IKU</th>
                        <th>Cluster</th>
                        <th>Label</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginatedData as $i => $item)
                        <tr class="text-center">
                            <td>{{ ($paginatedData->currentPage() - 1) * $paginatedData->perPage() + $i + 1 }}</td>
                            <td>{{ $item['id_usulan'] }}</td>
                            <td>{{ $item['iku'] }}</td>
                            <td>{{ $item['cluster'] }}</td>
                            <td>{{ $item['label'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $paginatedData->links() }}
            </div>
        @else
            <div></div>
        @endif
    </div>




    {{-- Scatter Plot Visualisasi --}}
    <div x-data x-init="const rawData = {{ Js::from($scatterData) }};
    console.log('Data Loaded:', rawData);
    
    const colors = [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)',
        'rgba(0, 0, 0, 0.7)'
    ];
    
    function groupByLabel(data, xKey, yKey) {
        const grouped = {};
        data.forEach(item => {
            const label = item.label;
            if (!grouped[label]) grouped[label] = [];
            grouped[label].push({
                x: item[xKey],
                y: item[yKey],
                id_usulan: item.id_usulan
            });
        });
        return grouped;
    }
    
    function buildChart(canvasId, xKey, yKey, xLabel, yLabel, xMax = null, yMax = null, xMin = null, yMin = null) {
        const grouped = groupByLabel(rawData, xKey, yKey);
        const datasets = Object.keys(grouped).map((label, idx) => ({
            label,
            data: grouped[label],
            backgroundColor: colors[idx % colors.length],
            pointRadius: 5,
            parsing: false,
            showLine: false
        }));
    
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
    
        const scalesConfig = {
            x: { title: { display: true, text: xLabel } },
            y: { title: { display: true, text: yLabel } }
        };
    
        if (xMin !== null) scalesConfig.x.min = xMin;
        if (xMax !== null) scalesConfig.x.max = xMax;
        if (yMin !== null) scalesConfig.y.min = yMin;
        if (yMax !== null) scalesConfig.y.max = yMax;
    
        new Chart(canvas.getContext('2d'), {
            type: 'scatter',
            data: { datasets },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: ctx => {
                                const p = ctx.raw;
                                return `ID: ${p.id_usulan}, X: ${p.x}, Y: ${p.y}`;
                            }
                        }
                    },
                    legend: { display: true }
                },
                scales: scalesConfig
            }
        });
    }
    
    // Jalankan 3 visualisasi
    buildChart('plotIkuVsRab', 'iku', 'nilai_rab_usulan', 'Indikator Kinerja Utama (IKU)', 'Nilai Anggaran (Rp)', null, 100000000);
    buildChart('plotIkuVsRisiko', 'iku', 'skor_risiko', 'Indikator Kinerja Utama (IKU)', 'Tingkat Risiko');
    buildChart('plotRabVsRisiko', 'nilai_rab_usulan', 'skor_risiko', 'Nilai Anggaran (Rp)', 'Tingkat Risiko', 100000000);">
        @if (empty($scatterData))
        @else
            <div class="row justify-content-center mt-5">
                <div class="col-md-3">
                    <h5 class="text-center">Visualisasi Klaster</h5>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4">
                    <label class="d-block text-center w-100"><strong>Indikator Kinerja Utama (IKU) vs Nilai Anggaran
                            (max: 100jt)</strong></label>
                    <canvas id="plotIkuVsRab" height="300"></canvas>
                </div>
                <div class="col-md-4">
                    <label class="d-block text-center w-100"><strong>Indikator Kinerja Utama (IKU) vs Tingkat
                            Risiko</strong></label>
                    <canvas id="plotIkuVsRisiko" height="300"></canvas>
                </div>
                <div class="col-md-4">
                    <label class="d-block text-center w-100"><strong>Nilai Anggaran vs Tingkat Risiko (max:
                            100jt)</strong></label>
                    <canvas id="plotRabVsRisiko" height="300"></canvas>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
