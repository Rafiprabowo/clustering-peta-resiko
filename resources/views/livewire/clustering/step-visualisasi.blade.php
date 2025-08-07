<div>
    {{-- Alert jika ada pesan flash --}}
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    {{-- Tombol aksi --}}
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end gap-2">
            <button wire:click.prevent="simpanHasilClustering" wire:loading.attr="disabled" class="btn btn-primary"
                @if ($sudahDisimpan) disabled @endif>

                <span wire:loading.remove wire:target="simpanHasilClustering">
                    <i class="fas fa-save me-1"></i> Simpan Hasil Clustering
                </span>

                <span wire:loading wire:target="simpanHasilClustering">
                    <span class="spinner-border spinner-border-sm"></span> Menyimpan...
                </span>
            </button>


            <a href="{{ route('clustering.export.pdf', $prosesClusteringId) }}" class="btn btn-danger  ml-2">
                <i class="fas fa-file-pdf me-1"></i>
            </a>
        </div>
    </div>

    {{-- Chart visualisasi --}}
    <div x-data x-init="const rawData = {{ Js::from($scatterData) }};
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
                    legend: {
                        display: true
                    }
                },
                scales: scalesConfig
            }
        });
    }
    
    buildChart('plotIkuVsRab', 'iku', 'nilai_rab_usulan', 'Indikator Kinerja Utama (IKU)', 'Nilai Anggaran', null, 100000000);
    buildChart('plotIkuVsRisiko', 'iku', 'skor_risiko', 'Indikator Kinerja Utama (IKU)', 'Tingkat Risiko');
    buildChart('plotRabVsRisiko', 'nilai_rab_usulan', 'skor_risiko', 'Nilai Anggaran', 'Tingkat Risiko', 100000000);">
        @if (empty($scatterData))
            <div class="alert alert-warning mt-3">Data scatter kosong atau belum tersedia.</div>
        @else
            <div class="mt-4">
                <div class="row justify-content-center text-center">
                    <div class="col-md-4 mb-4">
                        <label for="">IKU vs Nilai Anggaran (Max: 100 Juta)</label>
                        <canvas id="plotIkuVsRab" height="300"></canvas>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="">IKU vs Tingkat Risiko</label>
                        <canvas id="plotIkuVsRisiko" height="300"></canvas>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label for="">Nilai Anggaran vs Tingkat Risiko (Max: 100 Juta)</label>
                        <canvas id="plotRabVsRisiko" height="300"></canvas>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs" crossorigin="anonymous"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // TIDAK pakai DOMContentLoaded karena Alpine.js dan Livewire bisa delay render
        window.addEventListener('clustering-saved', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Hasil clustering berhasil disimpan.',
                confirmButtonColor: '#3085d6',
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>
@endpush
