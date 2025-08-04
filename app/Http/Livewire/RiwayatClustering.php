<?php

namespace App\Http\Livewire;

use App\Models\ProsesClustering;
use Livewire\Component;
use Livewire\WithPagination;

class RiwayatClustering extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['hapusRiwayat' => 'hapus'];

    public function hapus($id)
    {
        $riwayat = ProsesClustering::find($id);

        if ($riwayat) {
            $riwayat->clusteredData()->delete(); // jika ada relasi clusteredData
            $riwayat->delete();

            $this->dispatchBrowserEvent('upload-success', [
                'title' => 'Berhasil!',
                'message' => 'Riwayat clustering berhasil dihapus!',
                'icon' => 'success'
            ]);
        } else {
            $this->dispatchBrowserEvent('upload-success', [
                'title' => 'Gagal!',
                'message' => 'Data tidak ditemukan.',
                'icon' => 'error'
            ]);
        }
    }

    public function render()
    {
        $riwayats = ProsesClustering::where('is_saved', true)
            ->withCount('clusteredData')
            ->paginate(5);

        return view('livewire.riwayat-clustering', compact('riwayats'));
    }
}

