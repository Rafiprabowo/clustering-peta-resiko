<?php

namespace App\Http\Controllers;

use App\Models\ClusteringRun;
use Illuminate\Support\Str;
use App\Models\ClusterPeta;
use App\Models\InterpretasiCluster;

use App\Models\PetaRisikoMentah;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

class AnalisisPetaRisikoController extends Controller
{

    public function index(Request $request){
        $active = 6;

        $years = ClusteringRun::select('tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        $selectedYear = $request->input('year', date('Y'));

        $clusteringRuns = ClusteringRun::where('tahun', $selectedYear)
            ->orderByDesc('silhouette_score')
            ->orderByDesc('created_at')
            ->first();

        $clusteredByUnit = collect();

        if ($clusteringRuns) {
            $clusteredData = $clusteringRuns->clusters()
                ->with(['cleaned', 'interpretasi']) // pastikan eager load interpretasi juga
                ->get()
                ->groupBy(fn($cluster) => $cluster->cleaned->nmUnit ?? 'Tanpa Unit');

            $clusteredByUnit = $clusteredData->map(function($rows, $unit) {
                $total = $rows->count();

                $clusters = $rows->groupBy('cluster')->map(function ($clusterRows, $clusterNum) {
                    $interpretasi = optional($clusterRows->first()->interpretasi)->interpretasi ?? 'Tanpa Label';

                    return [
                        'label' => $interpretasi,
                        'jumlah' => $clusterRows->count()
                    ];
                });

                return [
                    'unit' => $unit,
                    'total' => $total,
                    'clusters' => $clusters
                ];
            });

            // Urutkan berdasarkan nama unit
            $clusteredByUnit = $clusteredByUnit->sortBy('unit')->values();
        }

        // Interpretasi per cluster
        $interpretasiClusters = InterpretasiCluster::where('id_clustering_run', optional($clusteringRuns)->id)
            ->orderBy('cluster')
            ->get()
            ->keyBy('cluster');

        // Paginate result
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $clusteredByUnit->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $clusteredByUnitPaginated = new LengthAwarePaginator(
            $pagedData,
            $clusteredByUnit->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('analisisPR.index', compact(
            'active',
            'clusteredByUnitPaginated',
            'years',
            'selectedYear',
            'interpretasiClusters'
        ));
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



    public function detailCluster(Request $request){
        $active = 6;

        $selectedYear = $request->input('tahun');

        $detailClusters = DB::table('cluster_labels')
            ->select()
            ->when($selectedYear, function ($q) use($selectedYear){
                return $q->whereYear('created_at', $selectedYear);
            })
            ->get();

        return view('analisisPR.detailCluster', compact('active', 'detailClusters'));
    }

    public function pieChart(){
        $active = 6;

        $data = DB::table('peta_risiko_clusters as cluster')
        ->join('peta_risiko_mentahs as peta', 'cluster.id_peta_risiko_mentah', '=', 'peta.id')
        ->join('iku_peta', 'iku_peta.id_peta_risiko_mentah', '=', 'peta.id')
        ->join('master_ikus as iku', 'iku.id', '=', 'iku_peta.id_master_iku')
        ->select('cluster.cluster', 'iku.kode_iku', 'iku.uraian', 'peta.idUsulan')
        ->get();



        $chartData = $data->groupBy('cluster')->map(function ($items) {
            return $items->groupBy(function ($item) {
                return "{$item->kode_iku} - {$item->uraian}";
            })->map(function ($grouped) {
                return [
                    'count' => $grouped->count(),
                    'usulans' => $grouped->pluck('idUsulan')->unique()->values()
                ];
            });
        });




        return view('analisisPR.pieChart', compact('active', 'chartData'));
    }

    // public function getFilesByYear(Request $request){
    //     $year = $request->input('year');

    //     $files = DB::table('peta_risiko_files as f')
    //         ->join('peta_risiko_mentahs as m', 'f.id', '=', 'm.id_file_peta_risiko')
    //         ->whereYear('m.created_at', $year)
    //         ->select('f.nama_file')
    //         ->distinct()
    //         ->orderBy('f.nama_file')
    //         ->pluck('nama_file');

    //     return response()->json($files);
    // }


    public function detailClusterPerUnitKerja($unit, $tahun)
    {
        $active = 6;

        $decodedUnit = urldecode($unit);

        $petaRisikos = PetaRisikoMentah::with('cluster')
            ->where('nmUnit', $decodedUnit)
            ->whereYear('created_at', $tahun)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('analisisPR.detailClusterPerUnitKerja', compact('active', 'petaRisikos', 'decodedUnit', 'tahun'));
    }

    public function heatmap(){
        $active = 6;
        $rawData = DB::table('peta_risiko_clusters as c')
            ->join('iku_peta as ip', 'c.id_peta_risiko_mentah', '=', 'ip.id_peta_risiko_mentah')
            ->join('master_ikus as m', 'ip.id_master_iku', '=', 'm.id')
            ->select('m.kode_iku', 'c.cluster', DB::raw('count(*) as total'))
            ->groupBy('m.kode_iku', 'c.cluster')
            ->orderBy('m.kode_iku')
            ->get()
            ->groupBy('kode_iku');

        // Misal ada 5 cluster (0–4), sesuaikan jumlahnya kalau beda
        $clusterCount = 3;

        $formatted = $rawData->map(function ($rows, $iku) use ($clusterCount) {
            $data = array_fill(0, $clusterCount, 0);
            foreach ($rows as $row) {
                $data[$row->cluster] = $row->total;
            }
            return [
                'name' => $iku,
                'data' => $data,
            ];
        })->values();

        return view('analisisPR.heatmap', [
            'active' => $active,
            'heatmapData' => $formatted,
            'clusterCount' => $clusterCount
        ]);
    }

    public function grafikUnitKerja($unitKerja, $tahun){
        $active = 6;



        return view('analisisPR.grafikUnitKerja', compact('active'));
    }

}
