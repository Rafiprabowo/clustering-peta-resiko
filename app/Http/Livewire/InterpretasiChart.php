<?php

namespace App\Http\Livewire;

use App\Models\ClusteringRun;
use Livewire\Component;

class InterpretasiChart extends Component
{
    public $clusteringRunId;
    public $interpretasiData = [];

    public function mount($clusteringRunId)
    {
        $this->clusteringRunId = $clusteringRunId;
        $this->loadInterpretasi();
    }

    public function loadInterpretasi()
    {
        $clusteringRun = ClusteringRun::with('interpretasi')->findOrFail($this->clusteringRunId);

        $this->interpretasiData = $clusteringRun->interpretasi->map(function($item) {
            return [
                'cluster' => $item->cluster,
                'skor_iku' => $item->centroid['skor_iku'] ?? 0,
                'anggaran' => $item->centroid['anggaran'] ?? 0,
                'tingkat_risiko' => $item->centroid['tingkat_risiko'] ?? 0,
                'interpretasi' => $item->interpretasi
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.interpretasi-chart');
    }
}
