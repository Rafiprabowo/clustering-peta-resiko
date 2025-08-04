<?php

namespace App\Http\Livewire\Clustering;

use Livewire\Component;

class StepSelectFeatures extends Component
{
    public $prosesClusteringId;
    public $selectedFeatures = ['iku', 'nilai_rab_usulan', 'skor_risiko'];

    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
    }

    public function lanjut()
    {
        // Langsung kirim emit ke parent
        $this->emitUp('featuresSelected', [
            'prosesClusteringId' => $this->prosesClusteringId,
            'selectedFeatures' => $this->selectedFeatures
        ]);
    }

    public function render()
    {
        return view('livewire.clustering.step-select-features');
    }
}
