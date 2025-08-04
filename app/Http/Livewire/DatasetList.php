<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Dataset;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
class DatasetList extends Component
{
    use WithPagination;

    protected $listeners = ['datasetUploaded' => '$refresh', 'confirmDelete' => 'delete'];
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function delete($id)
    {
        try {
            $dataset = Dataset::findOrFail($id);

            if (Storage::exists($dataset->file_path)) {
                Storage::delete($dataset->file_path);
            }

            $dataset->delete();

            $this->dispatchBrowserEvent('upload-success', [
                'title' => 'Berhasil!',
                'message' => 'Dataset berhasil dihapus!',
                'icon' => 'success'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('upload-success', [
                'title' => 'Gagal!',
                'message' => 'Terjadi kesalahan saat menghapus dataset: ' . $e->getMessage(),
                'icon' => 'error'
            ]);
        }


    }

    public function render()
    {
        $datasets = \App\Models\Dataset::query()
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5); // <= pagination di sini

        return view('livewire.dataset-list', [
            'datasets' => $datasets,
        ]);
    }
}
