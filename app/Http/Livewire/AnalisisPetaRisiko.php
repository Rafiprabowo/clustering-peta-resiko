<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PetaCleaned;
use App\Models\ClusteringRun;
use App\Models\ClusterPeta;

class AnalisisPetaRisiko extends Component
{
    use WithPagination;

    public $fileId = '';
    public $year = '';
    public $cluster = '';

    public $files = [];
    public $years = [];
    public $clusters = [];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->files = ClusteringRun::orderByDesc('created_at')->get();

        $this->years = ClusteringRun::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        $this->clusters = ClusterPeta::select('cluster')
            ->distinct()
            ->pluck('cluster')
            ->toArray();
    }

    public function updatingFileId() { $this->resetPage(); }
    public function updatingYear() { $this->resetPage(); }
    public function updatingCluster() { $this->resetPage(); }

    public function render()
{
    $query = PetaCleaned::with(['preprocessing', 'cluster', 'clusteringRun'])
        ->when($this->fileId, fn($q) =>
            $q->where('id_clustering_run', $this->fileId)
        )
        ->when($this->year, fn($q) =>
            $q->whereHas('clusteringRun', fn($qr) =>
                $qr->whereYear('created_at', $this->year)
            )
        )
        ->when($this->cluster !== '', fn($q) =>
            $q->whereHas('cluster', fn($qc) =>
                $qc->where('cluster', $this->cluster)
            )
        )
        ->orderBy('nmUnit');

    $hasilClusterings = $query->paginate(10);

    return view('livewire.analisis-peta-risiko', [
        'hasilClusterings' => $hasilClusterings
    ]);
}

}

