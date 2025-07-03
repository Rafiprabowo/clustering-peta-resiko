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

        $this->rekapCluster = $cleaneds->groupBy(fn($item) => $item->cluster !== null ? $item->cluster->cluster : 'no_cluster')
            ->map(function ($group, $key) {
                $first = $group->first();
                $clusterId = $key === 'no_cluster' ? '-' : $key;
                return [
                    'cluster' => $clusterId,
                    'interpretasi' => $clusterId === '-' ? '-' : optional($first->cluster->interpretasi)->interpretasi ?? '-',
                    'total_kegiatan' => $group->count(),
                ];
            })
            ->values()
            ->toArray();

        $this->ikuCluster = $cleaneds->groupBy(fn($item) => $item->cluster !== null ? $item->cluster->cluster : 'no_cluster')
            ->map(function ($group, $key) {
                $first = $group->first();
                $clusterId = $key === 'no_cluster' ? '-' : $key;

                $ikus = $group->flatMap(function ($item) {
                    if (!$item->iku) return collect([]);
                    return collect(explode(',', $item->iku))->map(fn($v) => trim($v))->filter()->unique();
                })->unique();

                return [
                    'cluster' => $clusterId,
                    'interpretasi' => $clusterId === '-' ? '-' : optional($first->cluster->interpretasi)->interpretasi ?? '-',
                    'total_iku' => $ikus->count(),
                ];
            })
            ->values()
            ->toArray();


        $this->dispatchBrowserEvent('updateClusterChart', ['data' => $this->rekapCluster]);
        $this->dispatchBrowserEvent('updateIkuChart', ['data' => $this->ikuCluster]);
    }

    public function render()
    {
        return view('livewire.visualisasi-cluster');
    }
}
