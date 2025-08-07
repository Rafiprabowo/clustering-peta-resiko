<?php

namespace App\Http\Livewire\Clustering;

use Livewire\Component;

class Index extends Component
{
    public $currentStep = 'dataset'; // dataset, cleaning, transform, normalisasi, clustering, visualisasi

    protected $listeners = ['datasetSelected', 'cleaningCompleted', 'dataTransformed', 'normalizationCompleted', 'clusteringCompleted'];

    public $selectedDatasetId;
    public $prosesClusteringId;
    public $selectedFeatures = [];

    public function datasetSelected($datasetId, $prosesClusteringId)
    {
        $this->selectedDatasetId = $datasetId;
        $this->prosesClusteringId = $prosesClusteringId;

        $this->canAccess['cleaning'] = true;
        $this->currentStep = 'cleaning';
    }

    public function cleaningCompleted($prosesClusteringId)
    {
        // $this->selectedDatasetId = $datasetId;
        $this->prosesClusteringId = $prosesClusteringId;

        $this->canAccess['transform'] = true;
        $this->currentStep = 'transform'; // atau 'pilih-fitur'
    }

    public function dataTransformed($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->canAccess['normalisasi'] = true;
        $this->currentStep = 'normalisasi';
    }



    public function featuresSelected($data)
    {
        $this->prosesClusteringId = $data['prosesClusteringId'];
        $this->canAccess['normalisasi'] = true;
        $this->currentStep = 'normalisasi';
    }

    public function normalizationCompleted()
    {

        $this->canAccess['clustering'] = true;
        $this->currentStep = 'clustering';
    }

    public function clusteringCompleted()
    {

        $this->canAccess['visualisasi'] = true;
        $this->currentStep = 'visualisasi';
    }

     public function visualisasiCompleted()
    {

        $this->canAccess['dataset'] = true;
        $this->currentStep = 'dataset';
    }

    public function goToStep($step)
{
    if (isset($this->canAccess[$step]) && $this->canAccess[$step]) {
        $this->currentStep = $step;
    }
}



    public $canAccess = [
        'cleaning' => false,
        'transform' => false,
        'normalisasi' => false,
        'clustering' => false,
        'visualisasi' => false,
    ];

    public function mount()
    {
        // Jika ingin resume proses sebelumnya, bisa load session atau database
    }

    public function render()
    {
        return view('livewire.clustering.index');
    }
}




