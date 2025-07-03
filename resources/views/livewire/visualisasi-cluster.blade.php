<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label for="clusteringRunId">Pilih File Clustering</label>
                <select wire:model="clusteringRunId" class="form-control mb-2">
                    @foreach ($clusteringFiles as $file)
                        <option value="{{ $file->id }}">{{ $file->nama_file }} ({{ $file->tahun }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="unitKerja">Pilih Unit Kerja</label>
                <select wire:model="unitKerja" class="form-control mb-2">
                    <option value="">Semua</option>
                    @foreach ($unitKerjaList as $unit)
                        <option value="{{ $unit }}">{{ $unit }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mt-4">
                    <h5>Distribusi Kegiatan </h5>
                    <div style="max-width: 100%; max-height: 400px; margin: auto;">
                        <canvas id="clusterChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mt-4">
                    <h5>Total IKU Tercapai</h5>
                    <div style="max-width: 100%; max-height: 400px; margin: auto;">
                        <canvas id="ikuChart" style="width: 100%; height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let clusterChartInstance = null;
        let ikuChartInstance = null;

        function renderChart(ctxId, data, label, instanceVar) {
            const ctx = document.getElementById(ctxId).getContext('2d');
            const labels = data.map(item => `Cluster ${item.cluster} (${item.interpretasi})`);
            const totals = data.map(item => item[label]);

            // Warna konsisten: Merah, Kuning, Hijau, Biru
            const baseColors = [
                'rgba(255, 99, 132, 0.7)', // Merah
                'rgba(255, 205, 86, 0.7)', // Kuning
                'rgba(75, 192, 192, 0.7)', // Hijau
                'rgba(54, 162, 235, 0.7)' // Biru
            ];
            const colors = labels.map((_, idx) => baseColors[idx % baseColors.length]);

            if (instanceVar) instanceVar.destroy();

            return new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label === 'total_kegiatan' ? 'Total Kegiatan' : 'Total IKU',
                        data: totals,
                        backgroundColor: colors,
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => {
                                    let label = ctx.label || '';
                                    let value = ctx.raw || 0;
                                    let total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    let percent = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        document.addEventListener('livewire:load', function() {
            clusterChartInstance = renderChart('clusterChart', @json($rekapCluster), 'total_kegiatan',
                clusterChartInstance);
            ikuChartInstance = renderChart('ikuChart', @json($ikuCluster), 'total_iku', ikuChartInstance);
        });

        window.addEventListener('updateClusterChart', e => {
            clusterChartInstance = renderChart('clusterChart', e.detail.data, 'total_kegiatan',
                clusterChartInstance);
        });

        window.addEventListener('updateIkuChart', e => {
            ikuChartInstance = renderChart('ikuChart', e.detail.data, 'total_iku', ikuChartInstance);
        });
    </script>
@endpush
