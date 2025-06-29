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

    // Ambil list tahun
    $years = ClusteringRun::selectRaw('YEAR(created_at) as year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');

    // Ambil input filter
    $selectedYear = $request->tahun;

    // Ambil data jenisCount langsung tanpa ambil ClusteringRun dulu
    $jenisCount = PetaCleaned::select(
            'peta_cleaneds.nmUnit',
            DB::raw('COUNT(*) as total'),
            DB::raw('YEAR(peta_cleaneds.created_at) as tahun'),
            'clustering_runs.nama_file'
        )
        ->join('clustering_runs', 'peta_cleaneds.id_clustering_run', '=', 'clustering_runs.id')
        ->when($selectedYear, function ($query, $selectedYear) {
            $query->whereYear('peta_cleaneds.created_at', $selectedYear);
        })
        ->groupBy(
            'peta_cleaneds.nmUnit',
            DB::raw('YEAR(peta_cleaneds.created_at)'),
            'clustering_runs.nama_file'
        )
        ->orderBy('peta_cleaneds.nmUnit')
        ->paginate(5);

    return view('analisisPR.index', compact('active', 'years', 'selectedYear', 'jenisCount'));
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
   public function detailUnitKerja(Request $request){
        $active = 6;
        $unit = $request->query('unit');
        $year = $request->query('tahun', date('Y'));

        $clusteringRun = ClusteringRun::where('tahun', $year)
            ->orderByDesc('silhouette_score')
            ->orderByDesc('created_at')
            ->first();

        if (!$clusteringRun) {
            abort(404, 'Clustering tidak ditemukan untuk tahun tersebut.');
        }

        // Ambil interpretasi clusternya
        $interpretasiClusters = InterpretasiCluster::where('id_clustering_run', $clusteringRun->id)
            ->get()
            ->keyBy('cluster');

        // Ambil data hasil cluster untuk unit kerja ini
        $clusters = ClusterPeta::with('cleaned')
            ->where('id_clustering_run', $clusteringRun->id)
            ->whereHas('cleaned', fn($q) => $q->where('nmUnit', $unit))
            ->get()
            ->groupBy('cluster');

        // dd($clusters->toArray());

        // Buat paginasi per cluster
        $perPage = 5;
        $groupedByCluster = [];

        foreach ($clusters as $cluster => $items) {

            //ambil query pencarian untuk cluster ini
            $queryKey = "q_$cluster";
            $search = $request->query($queryKey);

            if($search){
                $items = $items->filter(function($item) use ($search){
                    return Str::contains(strtolower($item->cleaned->nmKegiatan ?? ''), strtolower($search));
                });
            }

            $pageParam = "page_cluster_$cluster";
            $currentPage = LengthAwarePaginator::resolveCurrentPage($pageParam);

            $paginated = new LengthAwarePaginator(
                $items->forPage($currentPage, $perPage)->values(),
                $items->count(),
                $perPage,
                $currentPage,
                ['pageName' => $pageParam, 'path' => request()->url(), 'query' => request()->query()]
            );

            $groupedByCluster[$cluster] = [
                'interpretasi' => $interpretasiClusters[$cluster]->interpretasi ?? 'Tanpa Interpretasi',
                'jumlah' => $items->count(),
                'paginator' => $paginated
            ];
        }

        return view('analisisPR.detailUnitKerja', compact('unit', 'year', 'groupedByCluster', 'active'));
    }

    public function getFilesByYear(Request $request)
    {
        $year = $request->year;

        $query = ClusteringRun::select('id', 'nama_file');

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $files = $query->get();

        return response()->json($files);
    }




}
