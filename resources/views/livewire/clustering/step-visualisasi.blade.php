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

    // Konfigurasi scales dengan pembatasan
    const scalesConfig = {
        x: {
            title: { display: true, text: xLabel }
        },
        y: {
            title: { display: true, text: yLabel }
        }
    };

    // Tambahkan pembatasan jika ditentukan
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

// Chart dengan pembatasan nilai anggaran maksimal 100 juta (100000000)
buildChart('plotIkuVsRab', 'iku', 'nilai_rab_usulan', 'Indikator Kinerja Utama (IKU)', 'Nilai Anggaran', null, 100000000);

// Chart dengan pembatasan nilai anggaran dan IKU
buildChart('plotIkuVsRisiko', 'iku', 'skor_risiko', 'Indikator Kinerja Utama (IKU)', 'Tingkat Risiko');

// Chart dengan pembatasan nilai anggaran maksimal 100 juta
buildChart('plotRabVsRisiko', 'nilai_rab_usulan', 'skor_risiko', 'Nilai Anggaran', 'Tingkat Risiko', 100000000);">

    @if (empty($scatterData))
        <div class="alert ">Data scatter kosong</div>
    @else
    <div class="mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <label for="">Nilai Anggaran dan Indikator Kinerja Utama (IKU) (Max: 100 Juta)</label>
                <canvas id="plotIkuVsRab" height="300"></canvas>
            </div>

            <div class="col-md-4">
                <label for="">Tingkat Risiko dan Indikator Kinerja Utama (IKU)</label>
                <canvas id="plotIkuVsRisiko" height="300"></canvas>
            </div>
            <div class="col-md-4">
                <label for="">Tingkat Risiko dan Nilai Anggaran (Max: 100 Juta)</label>
                <canvas id="plotRabVsRisiko" height="300"></canvas>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
