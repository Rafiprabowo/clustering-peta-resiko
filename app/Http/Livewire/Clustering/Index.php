<?php

namespace App\Http\Livewire\Clustering;

use Livewire\Component;

// class Index extends Component
// {
//     public $currentStep = 'dataset'; // dataset, cleaning, transform, normalisasi, clustering, visualisasi

//     protected $listeners = ['datasetSelected', 'cleaningCompleted', 'dataTransformed','featuresSelected', 'normalizationCompleted', 'clusteringCompleted'];

//     public $selectedDatasetId;
//     public $prosesClusteringId;
//     public $selectedFeatures = [];

//     public function datasetSelected($datasetId, $prosesClusteringId)
//     {
//         $this->selectedDatasetId = $datasetId;
//         $this->prosesClusteringId = $prosesClusteringId;

//         $this->canAccess['cleaning'] = true;
//         $this->currentStep = 'cleaning';
//     }

//     public function cleaningCompleted($prosesClusteringId)
//     {
//         // $this->selectedDatasetId = $datasetId;
//         $this->prosesClusteringId = $prosesClusteringId;

//         $this->canAccess['transform'] = true;
//         $this->currentStep = 'transform'; // atau 'pilih-fitur'
//     }

//     public function dataTransformed($prosesClusteringId)
//     {
//         // $this->selectedDatasetId = $datasetId;
//         $this->prosesClusteringId = $prosesClusteringId;

//         $this->canAccess['pilih-fitur'] = true;
//         $this->currentStep = 'pilih-fitur'; // atau 'pilih-fitur'
//     }

//     public function featuresSelected($data)
//     {
//         $this->prosesClusteringId = $data['prosesClusteringId'];
//         $this->canAccess['normalisasi'] = true;
//         $this->currentStep = 'normalisasi';
//     }

//     public function normalizationCompleted()
//     {

//         $this->canAccess['clustering'] = true;
//         $this->currentStep = 'clustering';
//     }

//     public function clusteringCompleted()
//     {

//         $this->canAccess['visualisasi'] = true;
//         $this->currentStep = 'visualisasi';
//     }

//      public function visualisasiCompleted()
//     {

//         $this->canAccess['dataset'] = true;
//         $this->currentStep = 'dataset';
//     }

//     public function goToStep($step)
// {
//     if (isset($this->canAccess[$step]) && $this->canAccess[$step]) {
//         $this->currentStep = $step;
//     }
// }



//     public $canAccess = [
//         'cleaning' => false,
//         'transform' => false,
//         'pilih-fitur' => false,
//         'normalisasi' => false,
//         'clustering' => false,
//         'visualisasi' => false,
//     ];

//     public function mount()
//     {
//         // Jika ingin resume proses sebelumnya, bisa load session atau database
//     }

//     public function render()
//     {
//         return view('livewire.clustering.index');
//     }
// }



class Index extends Component
{
    public $currentStep = 'dataset'; // dataset, cleaning, transform, normalisasi, clustering, visualisasi

    protected $listeners = [
        'datasetSelected',
        'cleaningCompleted',
        'dataTransformed',
        'featuresSelected',
        'normalizationCompleted',
        'clusteringCompleted'
    ];

    public $selectedDatasetId;
    public $prosesClusteringId;
    public $selectedFeatures = [];

    public function datasetSelected($datasetId, $prosesClusteringId)
    {
        $this->selectedDatasetId = $datasetId;
        $this->prosesClusteringId = $prosesClusteringId;
        $this->currentStep = 'cleaning';
    }

    public function cleaningCompleted($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->currentStep = 'transform';
    }

    public function dataTransformed($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->currentStep = 'pilih-fitur';
    }

    public function featuresSelected($data)
    {
        $this->prosesClusteringId = $data['prosesClusteringId'];
        $this->currentStep = 'normalisasi';
    }

    public function normalizationCompleted()
    {
        $this->currentStep = 'clustering';
    }

    public function clusteringCompleted()
    {
        $this->currentStep = 'visualisasi';
    }

    public function visualisasiCompleted()
    {
        $this->currentStep = 'dataset';
    }

    public function goToStep($step)
    {
        $this->currentStep = $step; // semua langkah dibolehkan
    }

    public function render()
    {
        return view('livewire.clustering.index');
    }
}
