<?php

namespace App\Http\Livewire\Clustering;

use App\Models\DataCleanedClustering;
use App\Models\DataMentahClustering;
use App\Models\ProsesClustering;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class StepCleaning extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['page'];

    public $sudahDibersihkan = false;
    public $editingId = null;
    public $editData = [];
    public $invalidRows = [];
    public $filterDampak = '';
    public $prosesClusteringId;

    public function mount($prosesClusteringId)
    {
        $this->prosesClusteringId = $prosesClusteringId;
        $this->sudahDibersihkan = DataCleanedClustering::where('proses_clustering_id', $prosesClusteringId)->exists();

        if (!ProsesClustering::find($prosesClusteringId)) {
            abort(404, 'Proses clustering tidak ditemukan.');
        }

        $this->resetPage();
    }

    public function updatedFilterDampak()
    {
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->filterDampak = '';
        $this->resetPage();
    }

    public function getCleanedDataProperty()
    {
        return DataCleanedClustering::where('proses_clustering_id', $this->prosesClusteringId)->paginate(10);
    }

  public function render()
{
    $fields = ['iku', 'nilai_rab_usulan', 'dampak', 'probabilitas'];
    $query = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId);

    $totalData = $query->count();

    $data = $query
        ->orderByRaw("CASE WHEN iku IS NULL OR iku = '' THEN 0 ELSE 1 END")
        ->orderByRaw("CASE WHEN nilai_rab_usulan IS NULL OR nilai_rab_usulan = '' OR nilai_rab_usulan = 0 THEN 0 ELSE 1 END")
        ->orderByRaw("CASE WHEN dampak IS NULL OR dampak = '' THEN 0 ELSE 1 END")
        ->orderByRaw("CASE WHEN probabilitas IS NULL OR probabilitas = '' THEN 0 ELSE 1 END")
        ->paginate(10);

    $missingCounts = [];

    foreach ($fields as $field) {
        $missingCounts[$field] = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->where(function ($q) use ($field) {
                $q->whereNull($field)->orWhere($field, '');

                // Tambahan khusus untuk nilai_rab_usulan = 0
                if ($field === 'nilai_rab_usulan') {
                    $q->orWhere($field, 0);
                }
            })
            ->count();
    }

    $duplicateCount = DataMentahClustering::select('nama_kegiatan')
        ->where('proses_clustering_id', $this->prosesClusteringId)
        ->groupBy('nama_kegiatan')
        ->havingRaw('COUNT(*) > 1')
        ->count();

    return view('livewire.clustering.step-cleaning', [
        'data' => $data,
        'cleanedData' => $this->sudahDibersihkan ? $this->cleanedData : null,
        'missingCounts' => $missingCounts,
        'duplicateCount' => $duplicateCount,
        'totalData' => $totalData,
        'isDataBersih' => $this->isDataBersih(),
    ]);
}


    public function isDataBersih()
{
   $fields = ['iku', 'nilai_rab_usulan', 'dampak', 'probabilitas'];

    foreach ($fields as $field) {
        $query = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->where(function ($q) use ($field) {
                $q->whereNull($field)
                ->orWhere($field, '');

                // Tambahan khusus untuk nilai_rab_usulan
                if ($field === 'nilai_rab_usulan') {
                    $q->orWhere($field, 0);
                }
            });

        if ($query->count() > 0) {
            return false;
        }
    }


    // Cek duplikat
    $duplicateCount = DataMentahClustering::select('nama_kegiatan')
        ->where('proses_clustering_id', $this->prosesClusteringId)
        ->groupBy('nama_kegiatan')
        ->havingRaw('COUNT(*) > 1')
        ->count();

    return $duplicateCount === 0;
}


    public function edit($id)
    {
        $this->editingId = $id;
        $item = DataMentahClustering::findOrFail($id);

        $this->editData = $item->toArray();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editData = [];
    }

    public function update($id)
    {
        $this->validate([
            'editData.iku' => 'nullable|string',
            'editData.id_usulan' => 'nullable|string',
            'editData.nama_kegiatan' => 'nullable|string',
            'editData.nilai_rab_usulan' => 'nullable|numeric',
            'editData.nama_unit' => 'nullable|string',
            'editData.resiko' => 'nullable|string',
            'editData.dampak' => 'nullable|string',
            'editData.probabilitas' => 'nullable|string',
        ]);

        DataMentahClustering::findOrFail($id)->update($this->editData);

        $this->cancelEdit();
    }

    public function delete($id)
    {
        DataMentahClustering::findOrFail($id)->delete();
    }

    public function cleanData()
{
    $rows = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId)->get();

    $response = Http::post('http://fastapi:8001/cleaning', $rows->toArray());

    if ($response->successful()) {
        $cleaned = $response->json();

        $validIds = collect($cleaned)->pluck('id_usulan')->all();

        // Hapus semua data mentah yang tidak termasuk hasil cleaning
        $deleted = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->whereNotIn('id_usulan', $validIds)
            ->delete();

        // Update nilai untuk baris yang masih valid
        $updatedCount = 0;
        foreach ($cleaned as $row) {
            $affected = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId)
                ->where('id_usulan', $row['id_usulan'])
                ->update([
                    'iku' => $row['iku'],
                    'nilai_rab_usulan' => $row['nilai_rab_usulan'],
                    'dampak' => $row['dampak'],
                    'probabilitas' => $row['probabilitas'],
                ]);

            if ($affected > 0) {
                $updatedCount++;
            }
        }

        $this->resetPage();
        session()->flash('message', "$updatedCount baris diperbarui, $deleted baris tidak valid dihapus.");
    } else {
        session()->flash('error', 'Gagal membersihkan data di server Python.');
    }
}

  public function lanjut()
{
    $fields = ['iku', 'nilai_rab_usulan', 'dampak', 'probabilitas'];

    // Validasi ulang agar tidak lanjut jika masih kotor
    foreach ($fields as $field) {
        $count = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId)
            ->where(function ($q) use ($field) {
                $q->whereNull($field)->orWhere($field, '');
            })->count();

        if ($count > 0) {
            session()->flash('error', 'Masih ada data yang belum bersih.');
            return;
        }
    }

    // Cek duplikat
    $duplicateCount = DataMentahClustering::select('nama_kegiatan')
        ->where('proses_clustering_id', $this->prosesClusteringId)
        ->groupBy('nama_kegiatan')
        ->havingRaw('COUNT(*) > 1')
        ->count();

    if ($duplicateCount > 0) {
        session()->flash('error', 'Masih ada data duplikat berdasarkan nama_kegiatan.');
        return;
    }

    // Simpan ke data_cleaned_clustering
    $rows = DataMentahClustering::where('proses_clustering_id', $this->prosesClusteringId)->get();

    foreach ($rows as $row) {
        DataCleanedClustering::create([
            'proses_clustering_id' => $row->proses_clustering_id,
            'iku' => $row->iku,
            'id_usulan' => $row->id_usulan,
            'nama_kegiatan' => $row->nama_kegiatan,
            'nilai_rab_usulan' => $row->nilai_rab_usulan,
            'nama_unit' => $row->nama_unit,
            'resiko' => $row->resiko,
            'dampak' => $row->dampak,
            'probabilitas' => $row->probabilitas,
        ]);
    }

    $this->sudahDibersihkan = true;
    session()->flash('message', 'Data berhasil disimpan ke tabel cleaned.');

    $this->emitUp('cleaningCompleted', $this->prosesClusteringId);
}

}
