<?php

namespace App\Http\Livewire\Clustering;

use App\Models\ProsesClustering;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class HasilClustering extends Component
{
    use WithPagination;

    public $prosesClusteringId;
    public $dataIku;
    public $perPage = 10;

    public $filterIku = 'all';
    public $filterLabel = 'all';

    public $ikuOptions = [];
    public $labelOptions = [];
    public $jumlahPerCluster = [];


    protected $paginationTheme = 'bootstrap';

    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->dataIku = collect();

        $proses = ProsesClustering::with(['clusteredData.cleaned', 'interpretations'])->findOrFail($this->prosesClusteringId);

        $grouped = collect();

        foreach ($proses->clusteredData as $row) {
            $ikuList = explode(',', $row->cleaned->iku);
            $cluster = $row->cluster;

            $label = optional($proses->interpretations->firstWhere('cluster', $cluster))->label ?? 'Cluster ' . $cluster;

            foreach ($ikuList as $iku) {
                $iku = trim($iku);

                $grouped->push([
                    'label' => $label,
                    'cluster' => $cluster,
                    'iku' => $iku,
                    'id_usulan' => $row->cleaned->id_usulan
                ]);
            }
        }

        $this->dataIku = $grouped;
        $this->ikuOptions = $grouped->pluck('iku')->unique()->sort()->values()->all();
        $this->labelOptions = $grouped->pluck('label')->unique()->sort()->values()->all();
        $this->jumlahPerCluster = $grouped->groupBy('cluster')->map(function ($items, $cluster) {
            return [
                'cluster' => $cluster,
                'label' => $items->first()['label'],
                'jumlah' => $items->count(),
            ];
        })->sortKeys()->values()->all();

    }

    public function getFilteredDataProperty()
    {
        return $this->dataIku->filter(function ($item) {
            $ikuMatch = $this->filterIku === 'all' || $item['iku'] === $this->filterIku;
            $labelMatch = $this->filterLabel === 'all' || $item['label'] === $this->filterLabel;
            return $ikuMatch && $labelMatch;
        });
    }

    public function updated($property)
    {
        if (in_array($property, ['filterIku', 'filterLabel'])) {
            $this->resetPage();
        }
    }

    public function getPaginatedDataProperty()
    {
        $page = $this->page;
        $perPage = $this->perPage;

        $items = $this->filteredData;

        return new LengthAwarePaginator(
            $items->slice(($page - 1) * $perPage, $perPage),
            $items->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    public function getUniqueIkuPerClusterProperty()
    {
        return $this->dataIku->groupBy('cluster')->map(function ($items, $cluster) {
            return [
                'cluster' => $cluster,
                'label' => $items->first()['label'], // ambil label dari item pertama
                'ikus' => $items->pluck('iku')->unique()->sort()->values()->all()
            ];
        })->sortKeys();
    }



    public function render()
    {
        return view('livewire.clustering.hasil-clustering', [
            'paginatedData' => $this->paginatedData,
            'ikuOptions' => $this->ikuOptions,
            'labelOptions' => $this->labelOptions,
        ]);
    }
}
