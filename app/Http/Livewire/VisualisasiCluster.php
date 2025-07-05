<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PetaCleaned;
use App\Models\ClusteringRun;

class VisualisasiCluster extends Component
{
    public $clusteringRunId;
    public $unitKerja = '';
    public $clusteringFiles = [];
    public $unitKerjaList = [];
    public $rekapCluster = [];
    public $ikuCluster = [];
    public $clusterStats = [];

    public function mount()
    {
        $this->clusteringFiles = ClusteringRun::orderByDesc('created_at')->get();
        $this->clusteringRunId = optional($this->clusteringFiles->first())->id;
        $this->loadUnitKerjaList();
        $this->loadData();
    }

    public function updatedClusteringRunId()
    {
        $this->unitKerja = '';
        $this->loadUnitKerjaList();
        $this->loadData();
    }

    public function updatedUnitKerja()
    {
        $this->loadData();
    }

    private function loadUnitKerjaList()
    {
        $this->unitKerjaList = PetaCleaned::where('id_clustering_run', $this->clusteringRunId)
            ->select('nmUnit')
            ->distinct()
            ->orderBy('nmUnit')
            ->pluck('nmUnit')
            ->toArray();
    }

    public function loadData()
    {
        $query = PetaCleaned::with(['cluster.interpretasi'])
            ->where('id_clustering_run', $this->clusteringRunId);

        if ($this->unitKerja) {
            $query->where('nmUnit', $this->unitKerja);
        }

        $cleaneds = $query->get();

        $this->rekapCluster = $cleaneds->groupBy(fn($item) => $item->cluster?->cluster ?? 'no_cluster')
            ->map(fn($group, $key) => [
                'cluster' => $key,
                'interpretasi' => optional($group->first()->cluster?->interpretasi)->interpretasi ?? '-',
                'total_kegiatan' => $group->count(),
            ])->values()->toArray();

        $this->ikuCluster = $cleaneds->groupBy(fn($item) => $item->cluster?->cluster ?? 'no_cluster')
            ->map(fn($group, $key) => [
                'cluster' => $key,
                'interpretasi' => optional($group->first()->cluster?->interpretasi)->interpretasi ?? '-',
                'total_iku' => $group->sum(function ($item) {
                    if (!$item->iku) return 0;
                    return count(array_filter(array_map('trim', explode(',', $item->iku))));
                }),
            ])->values()->toArray();

        $this->clusterStats = $cleaneds->groupBy(fn($item) => $item->cluster?->cluster ?? 'no_cluster')
            ->map(fn($group, $key) => [
                'cluster' => $key,
                'interpretasi' => optional($group->first()->cluster?->interpretasi)->interpretasi ?? '-',
                'rata_iku' => round($group->sum(fn($i) => count(array_filter(array_map('trim', explode(',', $i->iku))))) / max(1, $group->count()), 2),
                'rata_anggaran' => round($group->avg('nilRabUsulan'), 2),
                'rata_risiko' => round($group->avg(fn($i) => optional($i->preprocessing)->normalisasi['tingkat_risiko'] ?? 0), 2),
            ])->values()->toArray();

        $this->dispatchBrowserEvent('updateClusterChart', ['data' => $this->rekapCluster]);
        $this->dispatchBrowserEvent('updateIkuChart', ['data' => $this->ikuCluster]);
        $this->dispatchBrowserEvent('updateClusterStatsChart', ['data' => $this->clusterStats]);
    }

    public function render()
    {
        return view('livewire.visualisasi-cluster');
    }
}
