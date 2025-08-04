<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DatasetController extends Controller
{
    public function index(){
        $active = 20;
        return view('dataset.index', compact('active'));
    }

    public function destroy($id)
    {
        $dataset = Dataset::findOrFail($id);

        // Hapus file dari storage kalau masih ada
        if (Storage::exists($dataset->file_path)) {
            Storage::delete($dataset->file_path);
        }

        // Hapus record dari database
        $dataset->delete();

        return redirect()->back()->with('success', 'Dataset berhasil dihapus.');
    }
}
