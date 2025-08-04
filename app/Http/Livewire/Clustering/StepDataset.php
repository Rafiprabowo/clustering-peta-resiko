<?php

namespace App\Http\Livewire\Clustering;

use App\Models\DataMentahClustering;
use Livewire\Component;
use App\Models\Dataset;
use App\Models\PetaRisiko;
use App\Models\ProsesClustering;

class StepDataset extends Component
{
    public $selectedYear;
    public $selectedDatasetId;


    public function render()
    {
        $years = Dataset::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderByDesc('year')
                ->pluck('year');

        $datasets = collect(); // default kosong
        if ($this->selectedYear) {
            $datasets = Dataset::whereYear('created_at', $this->selectedYear)
                        ->latest()->get();
        }
        $datasets = Dataset::latest()->get();
        return view('livewire.clustering.step-dataset', compact('years','datasets'));
    }

    public function submit()
    {
        if (!$this->selectedDatasetId) {
            $this->addError('selectedDatasetId', 'Pilih salah satu dataset terlebih dahulu.');
            return;
        }

        // Ambil data awal dari tabel peta_risikos
        $petaRisikos = PetaRisiko::where('dataset_id', $this->selectedDatasetId)->get();

        if ($petaRisikos->isEmpty()) {
            $this->addError('selectedDatasetId', 'Dataset ini tidak memiliki data peta risiko.');
            return;
        }

        $dataset = Dataset::findOrFail($this->selectedDatasetId);
        // 1. Simpan proses clustering
        $proses = ProsesClustering::create([
            'dataset_id' => $dataset->id,
            'nama_file' =>$dataset->original_name,
            'algoritma' => '', // atau kosong dulu, bisa diisi nanti
            'jumlah_data' => $petaRisikos->count(),
        ]);

         // 2. Salin data mentah
        foreach ($petaRisikos as $risiko) {
            DataMentahClustering::create([
                'proses_clustering_id' => $proses->id,
                'iku' => $risiko->iku,
                'id_usulan' => $risiko->id_usulan,
                'nama_kegiatan' => $risiko->nama_kegiatan,
                'nilai_rab_usulan' => $risiko->nilai_rab_usulan,
                'nama_unit' => $risiko->nama_unit,
                'resiko' => $risiko->resiko,
                'dampak' => $risiko->dampak,
                'probabilitas' => $risiko->probabilitas,
                'pernyataan_risiko' => $risiko->pernyataan_risiko,
                'uraian_dampak' => $risiko->uraian_dampak,
                'pengendalian' => $risiko->pengendalian,
            ]);
        }

        // Emit ke parent
        $this->emitUp('datasetSelected', $this->selectedDatasetId, $proses->id);
    }
}
