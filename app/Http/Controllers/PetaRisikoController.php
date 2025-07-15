<?php

namespace App\Http\Controllers;

use App\Imports\DatasetPetaRisikoImport;
use App\Models\ImportedDataset;
use App\Models\ImportedExcel;
use App\Models\PetaRisiko;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PetaRisikoController extends Controller
{
    public function index(Request $request){

    }

    public function formImport(){
        return view('clustering.dataset.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $namaFile = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        // Cek duplikat
        if (ImportedExcel::where('nama_file', $namaFile)->exists()) {
            return back()->with('error', 'File dengan nama ini sudah pernah diimpor.');
        }

        Excel::import(new DatasetPetaRisikoImport($namaFile), $file);

        return redirect()->route('datasetPetaRisiko.riwayat')->with('success', 'Dataset berhasil diimpor');
    }

    public function riwayat(){
        $riwayat = ImportedDataset::latest()->paginate(10);
        return view('clustering.dataset.riwayat', compact('riwayat'));
    }

     public function deleteByFile(Request $request)
    {
        $request->validate([
            'nama_file' => 'required|string'
        ]);

        $deleted = PetaRisiko::where('nama_file', $request->nama_file)->delete();
        ImportedDataset::where('nama_file', $request->nama_file)->delete();

        return back()->with('success', "dataset $request->nama_file  berhasil dihapus");
    }

    // public function export($nama_file)
    // {
    //     return Excel::download(new PetaRisikoExport($nama_file), "{$nama_file}.xlsx");
    // }

    // public function sendToApi($nama_file)
    // {
    //     $tempPath = storage_path("app/temp/{$nama_file}.xlsx");
    //     Excel::store(new PetaRisikoExport($nama_file), "temp/{$nama_file}.xlsx");

    //     $response = Http::attach(
    //         'file', file_get_contents($tempPath), "{$nama_file}.xlsx"
    //     )->post('https://endpoint-kamu.com/upload');

    //     if ($response->successful()) {
    //         return back()->with('success', 'Berhasil dikirim ke API.');
    //     }

    //     return back()->with('error', 'Gagal mengirim ke API.');
    // }
}
