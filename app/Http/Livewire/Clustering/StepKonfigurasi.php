<?php
namespace App\Http\Livewire\Clustering;

use App\Models\DataCentroidClustering;
use App\Models\DataClusteredClustering;
use App\Models\DataInterpretationClustering;
use App\Models\DataNormalizedClustering;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class StepKonfigurasi extends Component
{
    public $prosesClusteringId;
    public $jumlahCluster = 5;
    public $weightIku = 0.4;
    public $weightNilaiRab = 0.3;
    public $weightSkorRisiko = 0.3;
    public $showHasil = false;

    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->showHasil = DataClusteredClustering::where('proses_clustering_id', $prosesClusteringId)->exists();
    }

    public function resetClustering()
    {
        DB::transaction(function () {
            DataClusteredClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();
            DataCentroidClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();
            DataInterpretationClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();
        });

        $this->showHasil = false;
        session()->flash('message', 'Clustering berhasil direset.');
    }

    public function clustering()
    {
        if ($this->jumlahCluster < 2 || $this->jumlahCluster > 10) {
            session()->flash('error', 'Jumlah cluster harus antara 2 hingga 10.');
            return;
        }

        $totalWeight = $this->weightIku + $this->weightNilaiRab + $this->weightSkorRisiko;
        if (abs($totalWeight - 1.0) > 0.001) {
            session()->flash('error', 'Total bobot harus sama dengan 1.0');
            return;
        }

        $data = DataNormalizedClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->select('data_cleaned_id', 'iku', 'nilai_rab_usulan', 'skor_risiko')
            ->get();

        if ($data->count() < $this->jumlahCluster) {
            session()->flash('error', 'Jumlah data terlalu sedikit dibandingkan jumlah cluster.');
            return;
        }

        $payload = [
            'data' => $data->toArray(),
            'n_clusters' => $this->jumlahCluster,
            'weight_iku' => $this->weightIku,
            'weight_nilai_rab_usulan' => $this->weightNilaiRab,
            'weight_skor_risiko' => $this->weightSkorRisiko,
        ];

        try {
            $response = Http::timeout(30)->post('http://127.0.0.1:5000/clustering', $payload);
            if ($response->failed()) {
                throw new \Exception("Gagal menghubungi server Python: {$response->status()}");
            }

            $result = $response->json();

            if (!isset($result['clustered'], $result['centroids'], $result['interpretation'])) {
                throw new \Exception("Response dari API tidak lengkap");
            }

            DB::transaction(function () use ($result) {
                DataClusteredClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();
                DataCentroidClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();
                DataInterpretationClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();

                foreach ($result['clustered'] as $item) {
                    DataClusteredClustering::create([
                        'proses_clustering_id' => $this->prosesClusteringId,
                        'data_cleaned_id' => $item['data_cleaned_id'],
                        'cluster' => $item['cluster'],
                    ]);
                }

                foreach ($result['centroids'] as $item) {
                    DataCentroidClustering::create([
                        'proses_clustering_id' => $this->prosesClusteringId,
                        'cluster' => $item['cluster'],
                        'iku' => $item['iku'],
                        'nilai_rab_usulan' => $item['nilai_rab_usulan'],
                        'skor_risiko' => $item['skor_risiko'],
                    ]);
                }

                foreach ($result['interpretation'] as $item) {
                    DataInterpretationClustering::create([
                        'proses_clustering_id' => $this->prosesClusteringId,
                        'cluster' => $item['cluster'],
                        'label' => $item['label'],
                        'skor' => $item['skor'],
                    ]);
                }
            });

            session()->flash('message', 'Clustering berhasil disimpan.');
            $this->showHasil = true;

        } catch (\Exception $e) {
            Log::error('Clustering error: ' . $e->getMessage());
            session()->flash('error', 'Gagal clustering: ' . $e->getMessage());
        }
    }

    public function lanjut()
    {
        // Emit event ke komponen Livewire parent/tab handler
        $this->emitUp('clusteringCompleted');
    }

    public function render()
    {
        return view('livewire.clustering.step-konfigurasi');
    }
}
