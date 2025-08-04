<?php
namespace App\Http\Livewire;

use App\Imports\DatasetPetaRisikoImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Dataset;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UploadDatasetForm extends Component
{
    use WithFileUploads;

    public $file;

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls,csv',
    ];

    public function upload()
    {
        $this->validate();

        $fileName = $this->file->getClientOriginalName();
        $storagePath = 'datasets/' . $fileName;

        // Cek apakah file sudah ada di database
        $existsInDB = Dataset::where('original_name', $fileName)->exists();
        // Cek apakah file sudah ada di storage
        $existsInStorage = Storage::exists($storagePath);

        if ($existsInDB || $existsInStorage) {
            $this->dispatchBrowserEvent('upload-success', [
                'title' => 'Gagal!',
                'message' => 'File dengan nama yang sama sudah ada.',
                'icon' => 'error'
            ]);
            return;
        }

        $path = $this->file->storeAs('datasets', $fileName);

        $dataset = Dataset::create([
            'original_name' => $this->file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        Excel::import(new DatasetPetaRisikoImport($dataset->id), $this->file);

        $this->reset('file');

        $this->dispatchBrowserEvent('upload-success', [
            'title' => 'Berhasil!',
            'message' => 'Dataset berhasil diunggah!',
            'icon' => 'success'
        ]);
        
        $this->emit('datasetUploaded');
    }

    public function render()
    {
        return view('livewire.upload-dataset-form');
    }
}
