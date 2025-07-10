<?php

namespace App\Http\Livewire;

use App\Models\ClusterPetaRisiko;
use App\Models\Clustering;
use App\Models\Centroid;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class DashboardPetaRisiko extends Component
{
    public $quickChartUrl = null;
    public $ikuChartUrl = null;
    public $centroidCharts = [];
    public $clusterStats = [];
    public $ikuPerCluster = [];
    public $selectedClustering = null;
    public $clusteringList = [];

    protected $listeners = ['bukaModal'];

    public function mount()
    {
        $this->clusteringList = Clustering::pluck('nama_file', 'id')->toArray();
    }

    public function updatedSelectedClustering()
    {
        if ($this->selectedClustering) {
            $this->generateChart();
            $this->generateIkuChart();
            $this->generateCentroidCharts();
            $this->loadClusterStats();
            $this->generateIkuPerCluster();
        } else {
            $this->resetCharts();
        }
    }

    private function resetCharts()
    {
        $this->quickChartUrl = null;
        $this->ikuChartUrl = null;
        $this->centroidCharts = [];
        $this->clusterStats = [];
        $this->ikuPerCluster = [];
    }

    public function bukaModal($clusterId, $iku)
    {
        $data = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)
            ->where('cluster', $clusterId)
            ->get()
            ->filter(fn($item) => in_array($iku, array_map('trim', explode(',', $item->iku))))
            ->map(fn($item) => [
                'id_usulan' => $item->id_usulan,
                'iku' => $item->iku,
                'nama_kegiatan' => $item->nama_kegiatan,
                'nama_unit' => $item->nama_unit,
                'nilai_anggaran' => $item->nilai_anggaran,
                'dampak_angka' => $item->dampak_angka,
                'probabilitas_angka' => $item->probabilitas_angka,
                'tingkat_risiko' => $item->tingkat_risiko,
            ])
            ->values()
            ->toArray();

        $this->dispatchBrowserEvent('show-modal', [
            'title' => "Detail Usulan untuk $iku (Cluster $clusterId)",
            'data' => $data,
        ]);
    }

    // === Chart Generators ===
    public function generateChart()
    {
        $chartData = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)
            ->selectRaw('cluster, COUNT(*) as total')
            ->groupBy('cluster')
            ->orderBy('cluster')
            ->get();

        $labels = $chartData->pluck('cluster')->map(fn($val) => "Cluster $val")->toArray();
        $data = $chartData->pluck('total')->toArray();
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => '#000',
                    'borderWidth' => 2,
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => true, 'position' => 'bottom'],
                    'title' => ['display' => true, 'text' => 'Distribusi Jumlah Kegiatan per Cluster'],
                    'datalabels' => ['color' => '#fff', 'font' => ['weight' => 'bold', 'size' => 14]],
                ]
            ]
        ];

        $this->quickChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig)) . '&plugins=datalabels';
    }

    public function generateIkuChart()
    {
        $ikuData = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)
            ->select('cluster', 'iku')
            ->get()
            ->groupBy('cluster')
            ->sortKeys()
            ->map(fn($items) => $items->reduce(
                fn($carry, $item) => $carry + count(array_filter(array_map('trim', explode(',', $item->iku)))), 0
            ));

        $labels = $ikuData->keys()->map(fn($val) => "Cluster $val")->toArray();
        $data = $ikuData->values()->toArray();
        $colors = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'];

        $chartConfig = [
            'type' => 'pie',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => '#000',
                    'borderWidth' => 2,
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['display' => true, 'position' => 'bottom'],
                    'title' => ['display' => true, 'text' => 'Total IKU yang Tercapai per Cluster'],
                    'datalabels' => ['color' => '#fff', 'font' => ['weight' => 'bold', 'size' => 14]],
                ]
            ]
        ];

        $this->ikuChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig)) . '&plugins=datalabels';
    }

    public function generateCentroidCharts()
    {
        $centroids = Centroid::where('id_clustering', $this->selectedClustering)->orderBy('cluster')->get();
        $features = [
            'nilai_iku' => 'Nilai IKU',
            'nilai_anggaran' => 'Nilai Anggaran',
            'tingkat_risiko' => 'Tingkat Risiko'
        ];

        foreach ($features as $field => $label) {
            $labels = $centroids->pluck('cluster')->map(fn($val) => "Cluster $val")->toArray();
            $data = $centroids->pluck($field)->toArray();

            $chartConfig = [
                'type' => 'bar',
                'data' => [
                    'labels' => $labels,
                    'datasets' => [[
                        'label' => $label,
                        'data' => $data,
                        'backgroundColor' => '#36A2EB'
                    ]]
                ],
                'options' => [
                    'plugins' => [
                        'title' => ['display' => true, 'text' => "Karakteristik $label per Cluster"]
                    ]
                ]
            ];

            $this->centroidCharts[$field] = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));
        }
    }

    public function loadClusterStats()
    {
        $clusters = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)
            ->orderBy('cluster')
            ->get()
            ->groupBy('cluster');

        $this->clusterStats = $clusters->map(function ($items, $clusterId) {
            $ikuCounts = $items->map(fn($item) => count(array_filter(array_map('trim', explode(',', $item->iku)))));
            return [
                'cluster' => $clusterId,
                'min_iku' => $ikuCounts->min(),
                'max_iku' => $ikuCounts->max(),
                'avg_iku' => round($ikuCounts->avg(), 2),
                'min_anggaran' => $items->min('nilai_anggaran'),
                'max_anggaran' => $items->max('nilai_anggaran'),
                'avg_anggaran' => round($items->avg('nilai_anggaran'), 2),
                'min_risiko' => $items->min('tingkat_risiko'),
                'max_risiko' => $items->max('tingkat_risiko'),
                'avg_risiko' => round($items->avg('tingkat_risiko'), 2),
            ];
        })->values()->toArray();
    }

    public function generateIkuPerCluster()
    {
        $data = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)->get();
        $this->ikuPerCluster = $data->groupBy('cluster')->map(function ($items) {
            $ikuGrouped = [];
            foreach ($items as $item) {
                foreach (array_filter(array_map('trim', explode(',', $item->iku))) as $iku) {
                    $ikuGrouped[$iku]['total'] = ($ikuGrouped[$iku]['total'] ?? 0) + 1;
                    $ikuGrouped[$iku]['id_usulan'][] = $item->id_usulan;
                }
            }
            return $ikuGrouped;
        })->toArray();
    }

    public function exportPdf()
    {
        if (!$this->selectedClustering) {
            session()->flash('error', 'Pilih clustering terlebih dahulu!');
            return;
        }

        $this->loadClusterStats();
        $this->generateIkuPerCluster();

        $clustering = Clustering::find($this->selectedClustering);
        $this->generateChart();
        $this->generateIkuChart();

        // Ambil base64 untuk PDF
        $chartKegiatanBase64 = 'data:image/png;base64,' . base64_encode(Http::get($this->quickChartUrl)->body());
        $chartIkuBase64 = 'data:image/png;base64,' . base64_encode(Http::get($this->ikuChartUrl)->body());

        $pdf = Pdf::loadView('exports.analisis-peta-risiko-pdf', [
            'clusterStats' => $this->clusterStats,
            'ikuPerCluster' => $this->ikuPerCluster,
            'namaFile' => $clustering?->nama_file ?? '-',
            'chartKegiatan' => $chartKegiatanBase64,
            'chartIku' => $chartIkuBase64,
        ])->setPaper('A4', 'landscape');

        return response()->streamDownload(fn() => print($pdf->stream()), 'analisis-peta-risiko-' . ($clustering?->nama_file ?? 'clustering') . '.pdf');
    }

    public function render()
    {
        return view('livewire.dashboard-peta-risiko');
    }
}
