<?php

namespace App\Http\Livewire;

use App\Models\Clustering;
use App\Models\ClusterPetaRisiko;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;

class HasilClusterPetaRisiko extends Component
{
    use WithPagination;

    public $selectedClustering = null;

    protected $paginationTheme = 'bootstrap'; // opsional

    public function updatedSelectedClustering()
    {
        $this->resetPage(); // reset pagination saat memilih file baru
    }

    public function bukaModalPreprocessing($id)
    {
        $item = ClusterPetaRisiko::findOrFail($id);

        $data = [
            'id_usulan' => $item->id_usulan,
            'iku' => $item->iku,
            'iku_angka' => $item->iku_angka,
            'nilai_anggaran' => $item->nilai_anggaran,
            'nilai_anggaran_scaled' => $item->nilai_anggaran_scaled,
            'tingkat_risiko' => $item->tingkat_risiko,
            'tingkat_risiko_scaled' => $item->tingkat_risiko_scaled,
        ];

        $this->dispatchBrowserEvent('show-modal-preprocessing', [
            'title' => "Detail Preprocessing ID Usulan: {$item->id_usulan}",
            'data' => $data,
        ]);
    }


    public function render()
    {
        $clusterings = Clustering::all();
        $data = [];

        if ($this->selectedClustering) {
            $data = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)
                    ->paginate(10);
        }

        return view('livewire.hasil-cluster-peta-risiko', [
            'clusterings' => $clusterings,
            'data' => $data,
        ]);
    }

   public function exportDataPdf()
    {
        $data = ClusterPetaRisiko::where('id_clustering', $this->selectedClustering)->get();

        $pdf = Pdf::loadView('exports.hasil-cluster-pdf', [
            'data' => $data,
            'namaFile' => Clustering::find($this->selectedClustering)?->nama_file ?? 'Data Clustering'
        ]);

        return $pdf->download('data_clustering.pdf');
    }

}
