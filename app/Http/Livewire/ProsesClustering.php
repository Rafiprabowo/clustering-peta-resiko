<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ClusterPetaRisiko; // Model data
use App\Models\Clustering; // Model clustering file

class ProsesClustering extends Component
{
    use WithPagination;

    public $selectedYear;
    public $selectedClustering;
    public $activeTab = 'cleaning'; // default tab

    protected $paginationTheme = 'bootstrap';

    public function updatingSelectedYear()
    {
        $this->selectedClustering = null; // reset clustering saat tahun berubah
        $this->resetPage(); // reset halaman paginasi
    }

    public function updatingSelectedClustering()
    {
        $this->resetPage();
    }

    public function render()
    {
        $years = Clustering::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $clusteringList = [];

        if ($this->selectedYear) {
            $clusteringList = Clustering::whereYear('created_at', $this->selectedYear)
                ->orderBy('created_at', 'desc')
                ->pluck('nama_file', 'id')
                ->toArray();
        }

        $items = collect(); // kosong default

        if ($this->selectedYear && $this->selectedClustering) {
            $items = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)
                ->paginate(5);
        }

        return view('livewire.proses-clustering', [
            'years' => $years,
            'clusteringList' => $clusteringList,
            'items' => $items,
        ]);
    }
}
