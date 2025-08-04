<?php

namespace App\Http\Livewire\Clustering;

use App\Models\DataCleanedClustering;
use App\Models\DataTransformedClustering;
use Livewire\Component;
use Livewire\WithPagination;

class StepTransformasi extends Component
{
    use WithPagination;

    // Livewire butuh nama khusus jika bukan komponen root
    protected $paginationTheme = 'bootstrap';

    protected $updatesQueryString = ['page'];

    public $prosesClusteringId;
    public $availableFeatures = ['iku', 'nilai_rab_usulan', 'dampak', 'probabilitas'];
    public $selectedFeatures;

    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
    }

    public function transform()
    {
        if (DataTransformedClustering::where('proses_clustering_id', $this->prosesClusteringId)->exists()) {
            session()->flash('message', 'Data sudah pernah ditransformasi.');
            return;
        }

        $cleanedData = DataCleanedClustering::where('proses_clustering_id', $this->prosesClusteringId)->get();

        $dampakMap = [
            'sangat berpengaruh' => 5,
            'berpengaruh' => 4,
            'cukup berpengaruh' => 3,
            'sedikit berpengaruh' => 2,
            'sangat sedikit berpengaruh' => 1
        ];

        $probabilitasMap = [
            'sangat sering' => 5,
            'sering' => 4,
            'kadang-kadang' => 3,
            'jarang' => 2,
            'sangat jarang' => 1
        ];

        foreach ($cleanedData as $row) {
            $transformed = new DataTransformedClustering();
            $transformed->proses_clustering_id = $this->prosesClusteringId;
            $transformed->data_cleaned_id = $row->id;

            // Transformasi langsung semua fitur penting
            $transformed->iku = $this->hitungNilaiIkuIkt($row->iku);
            $transformed->nilai_rab_usulan = $row->nilai_rab_usulan;
            $transformed->dampak = $dampakMap[strtolower($row->dampak)] ?? null;
            $transformed->probabilitas = $probabilitasMap[strtolower($row->probabilitas)] ?? null;
            $transformed->skor_risiko = $transformed->dampak * $transformed->probabilitas;

            $transformed->save();
        }

        session()->flash('message', 'Transformasi semua fitur berhasil.');
        $this->emitUp('transformCompleted', $this->prosesClusteringId);
    }


    public function render()
    {
        $transformedData = DataTransformedClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->paginate(10);

        return view('livewire.clustering.step-transformasi', compact('transformedData'));
    }


    public function hitungNilaiIkuIkt($isi)
    {
        if (is_null($isi) || !is_string($isi)) {
            return 0;
        }

        $bagian = explode(',', strtolower($isi));
        $jumlah_iku = 0;
        $jumlah_ikt = 0;

        foreach ($bagian as $item) {
            $item = trim($item);
            if (str_contains($item, 'iku')) {
                $jumlah_iku++;
            }
            if (str_contains($item, 'ikt')) {
                $jumlah_ikt++;
            }
        }

        return intval(($jumlah_iku * 0.7) + ($jumlah_ikt * 0.3));
    }

    public function lanjut(){
        $this->emitUp('dataTransformed', $this->prosesClusteringId);
    }

}
