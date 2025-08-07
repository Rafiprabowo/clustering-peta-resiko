<?php

namespace App\Http\Livewire\Clustering;

use App\Models\DataTransformedClustering;
use App\Models\DataNormalizedClustering;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class StepNormalisasi extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['page'];

    public $prosesClusteringId;
    public $normalizedData;
    public $isNormalized = false;

    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
    }

    public function normalisasi()
{
    $collection = DataTransformedClustering::where('proses_clustering_id', $this->prosesClusteringId)
        ->select('iku', 'nilai_rab_usulan', 'skor_risiko', 'data_cleaned_id')
        ->get();

    if ($collection->isEmpty()) {
        session()->flash('error', 'Data transformasi tidak ditemukan.');
        return;
    }

    $payload = $collection->toArray();

    try {
        $response = Http::post('http://127.0.0.1:5000/normalisasi', [
            'data' => $payload
        ]);

        if ($response->failed()) {
            throw new \Exception('Gagal menghubungi server Python');
        }

        $normalized = $response->json();

        // Hapus hasil normalisasi lama agar tidak tumpuk
        DataNormalizedClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();

        foreach ($normalized as $item) {
            DataNormalizedClustering::create([
                'proses_clustering_id' => $this->prosesClusteringId,
                'data_cleaned_id' => $item['data_cleaned_id'],
                'iku' => $item['iku'],
                'nilai_rab_usulan' => $item['nilai_rab_usulan'],
                'skor_risiko' => $item['skor_risiko'],
            ]);
        }

        $this->isNormalized = true; // Aktifkan flag
        session()->flash('message', 'Normalisasi berhasil dilakukan.');
    } catch (\Exception $e) {
        session()->flash('error', 'Terjadi kesalahan saat normalisasi: ' . $e->getMessage());
    }
}


public function render()
{
    $this->isNormalized = DataNormalizedClustering::where('proses_clustering_id', $this->prosesClusteringId)->exists();

    $dataBefore = DataTransformedClustering::where('proses_clustering_id', $this->prosesClusteringId)
        ->select('iku', 'nilai_rab_usulan', 'skor_risiko')
        ->orderBy('id')
        ->paginate(10);

    $dataAfter = collect();

    if ($this->isNormalized) {
        $dataAfter = DataNormalizedClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->orderBy('id')
            ->paginate(10);
    }

    return view('livewire.clustering.step-normalisasi', compact('dataBefore', 'dataAfter'));
}

    public function lanjut()
    {
        $this->emitUp('normalizationCompleted', $this->prosesClusteringId);
    }


}
