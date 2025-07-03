<div class="row">
    <div class="col-md-4">
        <canvas id="chartAnggaran" height="300"></canvas>
    </div>
    <div class="col-md-4">
        <canvas id="chartIKU" height="300"></canvas>
    </div>
    <div class="col-md-4">
        <canvas id="chartRisiko" height="300"></canvas>
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        const data = @json($interpretasiData);

        const labels = data.map(item => `Cluster ${item.cluster} (${item.interpretasi})`);

        const anggaran = data.map(item => item.anggaran);
        const iku = data.map(item => item.skor_iku);
        const risiko = data.map(item => item.tingkat_risiko);

        // Chart Anggaran
        new Chart(document.getElementById('chartAnggaran').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Anggaran',
                    data: anggaran,
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: value => 'Rp ' + new Intl.NumberFormat('id-ID').format(value),
                        font: {
                            weight: 'bold'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y)
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Chart IKU
        new Chart(document.getElementById('chartIKU').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor IKU',
                    data: iku,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: value => value.toFixed(2),
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        // Chart Tingkat Risiko
        new Chart(document.getElementById('chartRisiko').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tingkat Risiko',
                    data: risiko,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    maxBarThickness: 50
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        formatter: value => value.toFixed(2),
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    </script>
@endpush
