<?php

namespace App\Http\Livewire\Clustering;

use App\Models\DataCentroidClustering;
use Livewire\Component;
use App\Models\DataNormalizedClustering;
use App\Models\DataClusteredClustering;
use App\Models\DataInterpretationClustering;
use App\Models\ProsesClustering;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StepClustering extends Component
{
    public $prosesClusteringId;
    public $jumlahCluster = 5; // default
    public $weightIku = 0.4;
    public $weightNilaiRab = 0.3;
    public $weightSkorRisiko = 0.3;
    public $showHasil = false;
    public $hasilSudahDisimpan;
    public $algoritma = 'kmeans'; // atau 'dbscan', 'hierarchical'
    public $epsilon; // hanya untuk DBSCAN


    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->showHasil = DataClusteredClustering::where('proses_clustering_id', $this->prosesClusteringId)->exists();
        $this->hasilSudahDisimpan = ProsesClustering::findOrFail($prosesClusteringId)->is_saved;
    }

    public function simpanHasilClustering()
    {
        $proses = ProsesClustering::findOrFail($this->prosesClusteringId);
        $proses->is_saved = true;
        $proses->save();

        $this->hasilSudahDisimpan = true;

        session()->flash('message', 'Hasil clustering berhasil disimpan.');
    }

    public function clustering()
    {
        // Validasi input
        if ($this->jumlahCluster < 2 || $this->jumlahCluster > 10) {
            session()->flash('error', 'Jumlah cluster harus antara 2-10');
            return;
        }

        // Validasi bobot
          $totalWeight = $this->weightIku + $this->weightNilaiRab + $this->weightSkorRisiko;

        if ($totalWeight < 0.999) {
            session()->flash('error', 'Total bobot kurang dari 1.0');
            return;
        } elseif ($totalWeight > 1.001) {
            session()->flash('error', 'Total bobot lebih dari 1.0');
            return;
        }

        $data = DataNormalizedClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->select('data_cleaned_id', 'iku', 'nilai_rab_usulan', 'skor_risiko')
            ->get();

        if ($data->isEmpty()) {
            session()->flash('error', 'Data normalisasi tidak ditemukan.');
            return;
        }

        // Pastikan jumlah data >= jumlah cluster
        if ($data->count() < $this->jumlahCluster) {
            session()->flash('error', 'Jumlah data (' . $data->count() . ') tidak boleh kurang dari jumlah cluster (' . $this->jumlahCluster . ')');
            return;
        }

        $payload = [
            'data' => $data->toArray(),
            'n_clusters' => $this->jumlahCluster,
            'weight_iku' => $this->weightIku,
            'weight_nilai_rab_usulan' => $this->weightNilaiRab,
            'weight_skor_risiko' => $this->weightSkorRisiko
        ];

        try {
            $response = Http::timeout(30)->post('http://127.0.0.1:5000/clustering', $payload);

            if ($response->failed()) {
                throw new \Exception('Gagal menghubungi server Python: ' . $response->status());
            }

            $result = $response->json();

            // Validasi response
            if (!isset($result['clustered']) || !isset($result['centroids']) || !isset($result['interpretation'])) {
                throw new \Exception('Response dari API tidak lengkap');
            }

            // Hapus hasil lama dalam transaksi
            DB::transaction(function () use ($result) {
                DataClusteredClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();
                DataCentroidClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();
                DataInterpretationClustering::where('proses_clustering_id', $this->prosesClusteringId)->delete();

                // Simpan clustered data
                foreach ($result['clustered'] as $item) {
                    DataClusteredClustering::create([
                        'proses_clustering_id' => $this->prosesClusteringId,
                        'data_cleaned_id' => $item['data_cleaned_id'],
                        'cluster' => $item['cluster'],
                    ]);
                }

                // Simpan centroids
                foreach ($result['centroids'] as $item) {
                    DataCentroidClustering::create([
                        'proses_clustering_id' => $this->prosesClusteringId,
                        'cluster' => $item['cluster'],
                        'iku' => $item['iku'],
                        'nilai_rab_usulan' => $item['nilai_rab_usulan'],
                        'skor_risiko' => $item['skor_risiko'],
                    ]);
                }

                // Simpan interpretations
                foreach ($result['interpretation'] as $item) {
                    DataInterpretationClustering::create([
                        'proses_clustering_id' => $this->prosesClusteringId,
                        'cluster' => $item['cluster'],
                        'label' => $item['label'],
                        'skor' => $item['skor'],
                    ]);
                }

                ProsesClustering::findOrFail($this->prosesClusteringId)->update([
                    'akurasi' => $result['akurasi'],
                ]);
            });

            session()->flash('message', 'Clustering berhasil dilakukan dengan ' . $this->jumlahCluster . ' cluster.');

            $this->showHasil = true;

            // Emit event ke parent untuk update akses visualisasi
            $this->emitUp('clusteringDataUpdated');

        } catch (\Exception $e) {
            Log::error('Clustering error: ' . $e->getMessage());
            session()->flash('error', 'Gagal clustering: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.clustering.step-clustering');
    }

    public function lanjut()
    {
        $this->emitUp('clusteringCompleted', $this->prosesClusteringId);
    }
}
