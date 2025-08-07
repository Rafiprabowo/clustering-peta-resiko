<?php

namespace App\Http\Livewire\Clustering;

use Livewire\Component;
use App\Models\ProsesClustering;

class StepVisualisasi extends Component
{
    public $prosesClusteringId;
    public $scatterData = [];

    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->loadScatterData();
    }

    public function loadScatterData()
    {
        $proses = ProsesClustering::with([
            'clusteredData.cleaned.transformed', // tambahkan relasi transformed
            'interpretations'
        ])->findOrFail($this->prosesClusteringId);

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
        })->toArray();

    }

    // StepVisualisasi.php
    public $sudahDisimpan = false;

    public function simpanHasilClustering()
    {
        $proses = ProsesClustering::findOrFail($this->prosesClusteringId);
        $proses->is_saved = true;
        $proses->save();

        $this->sudahDisimpan = true;

        // WAJIB: Kirim event ke browser
        $this->dispatchBrowserEvent('clustering-saved');
    }


    public function render()
    {
        return view('livewire.clustering.step-visualisasi');
    }

        public function kembali()
    {
        $this->emitUp('visualisasiCompleted', $this->prosesClusteringId);
    }
}
