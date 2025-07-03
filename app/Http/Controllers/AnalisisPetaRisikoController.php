<?php

namespace App\Http\Controllers;

use App\Models\ClusteringRun;
use Illuminate\Support\Str;
use App\Models\ClusterPeta;
use App\Models\InterpretasiCluster;
use App\Models\PetaCleaned;
use App\Models\PetaRisikoMentah;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class AnalisisPetaRisikoController extends Controller
{

public function index(Request $request)
{
    $active = 6;

    // Ambil list tahun dari relasi clustering_run (lebih konsisten)
    $years = ClusteringRun::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');

    $selectedYear = $request->tahun;

    // Ambil data PetaCleaned dengan relasi
    $hasilClusterings = PetaCleaned::with(['preprocessing', 'cluster', 'clusteringRun'])
        ->when($selectedYear, function ($query, $selectedYear) {
            $query->whereYear('created_at', $selectedYear);
        })
        ->orderBy('nmUnit')
        ->paginate(10);

    return view('analisisPR.index', compact(
        'active',
        'years',
        'selectedYear',
        'hasilClusterings'
    ));
}




    public function detailAnalisisPeta($unit, $tahun, $file){
        $active = 6;

        $file = urldecode($file);
        $unit = urldecode($unit);

        $analisisPetas = PetaCleaned::with(['cluster.interpretasi', 'clusteringRun'])
            ->where('nmUnit', $unit)
            ->whereYear('created_at', $tahun)
            ->whereHas('clusteringRun', function ($query) use ($file){
                $query->where('nama_file', $file);
            })
            ->paginate(10);

        return view('analisisPR.detailAnalisisPetaUnitKerja', compact('active', 'analisisPetas', 'unit', 'tahun', 'file'));
    }

    public function detailPR($id){
        $active = 6;

        $petas = PetaCleaned::findOrFail($id);

        return view('analisisPR.detailPR', compact('active', 'petas'));

    }







}
