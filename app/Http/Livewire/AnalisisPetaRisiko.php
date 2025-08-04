<?php

namespace App\Http\Livewire;

use App\Models\ProsesClustering;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

class AnalisisPetaRisiko extends Component
{
    use WithPagination;

    public $selectedYear;
    public $selectedFile;
    public $files;
    public $scatterData = null;
    public $tabelData = [];
    public $perPage = 10;
    public $ikuOptions = [];
    public $labelOptions = [];
    public $filterIku = '';
    public $filterLabel = '';
    public $uniqueIkuPerCluster = [];
    public $jumlahPerCluster = [];


    protected $paginationTheme = 'bootstrap';

    public function updatedSelectedYear()
    {
        $this->files = ProsesClustering::whereYear('created_at', $this->selectedYear)
            ->with('dataset')
            ->where('is_saved', true)
            ->get();

        $this->selectedFile = null;
        $this->scatterData = null;
        $this->tabelData = [];
    }

    public function updatedSelectedFile()
    {
        if ($this->selectedFile) {
            $proses = ProsesClustering::with([
                'clusteredData.cleaned.transformed',
                'interpretations'
            ])->find($this->selectedFile);

            $this->scatterData = $proses->clusteredData->map(function ($clustered) use ($proses) {
                $cleaned = $clustered->cleaned;
                $transformed = $cleaned->transformed;

                $interpretation = $proses->interpretations->firstWhere('cluster', $clustered->cluster);

                return [
                    'id_usulan' => $cleaned->id_usulan,
                    'iku' => (float) ($transformed->iku ?? 0),
                    'nilai_rab_usulan' => (float) ($transformed->nilai_rab_usulan ?? 0),
                    'skor_risiko' => (float) ($transformed->skor_risiko ?? 0),
                    'cluster' => $clustered->cluster,
                    'label' => $interpretation->label ?? 'Cluster ' . $clustered->cluster,
                ];
            });

            // Ambil data untuk tabel (dari cleaned)
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


            $this->tabelData = $grouped;
            $this->ikuOptions = $grouped->pluck('iku')->unique()->sort()->values()->all();
            $this->labelOptions = $grouped->pluck('label')->unique()->sort()->values()->all();
            $this->uniqueIkuPerCluster = $grouped
                ->groupBy('cluster')
                ->map(function ($items, $cluster) {
                    return [
                        'cluster' => $cluster,
                        'label' => $items->first()['label'],
                        'ikus' => $items->pluck('iku')->unique()->sort()->values()
                    ];
                })
                ->sortKeys() // sort by cluster
                ->values()
                ->toArray();
            $this->jumlahPerCluster = $this->scatterData
            ->groupBy('cluster')
            ->map(function ($items, $cluster) {
                $label = $items->first()['label'];
                $count = count($items);
                $avgIku = round($items->avg('iku'), 2);
                $avgRab = round($items->avg('nilai_rab_usulan'), 2);
                $avgRisiko = round($items->avg('skor_risiko'), 2);

                return [
                    'cluster' => $cluster,
                    'label' => $label,
                    'jumlah' => $count,
                    'rata_iku' => $avgIku,
                    'rata_rab' => $avgRab,
                    'rata_risiko' => $avgRisiko,
                ];
            })
            ->sortKeys()
            ->values()
            ->toArray();





        }
    }

     public function getPaginatedDataProperty()
{
    $page = $this->page;
    $perPage = $this->perPage;

    $items = collect($this->tabelData);

    // Filter berdasarkan IKU dan Label
    if ($this->filterIku) {
        $items = $items->where('iku', $this->filterIku);
    }

    if ($this->filterLabel) {
        $items = $items->where('label', $this->filterLabel);
    }

    return new LengthAwarePaginator(
        $items->values()->slice(($page - 1) * $perPage, $perPage),
        $items->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );
}
public function updated($property)
{
    if (in_array($property, ['filterIku', 'filterLabel'])) {
        $this->resetPage();
    }
}



    public function render()
    {
        $years = ProsesClustering::where('is_saved', true)
            ->selectRaw('YEAR(created_at) as year')->distinct()->orderByDesc('year')->pluck('year');

        return view('livewire.analisis-peta-risiko', [
            'years' => $years,
            'files' => $this->files ?? [],
            'scatterData' => $this->scatterData,
            'paginatedData' => $this->paginatedData
        ]);
    }
}
