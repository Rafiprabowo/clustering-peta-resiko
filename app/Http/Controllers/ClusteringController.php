<?php

namespace App\Http\Controllers;

use App\Models\ClusteringRun;
use App\Models\ClusterPeta;
use App\Models\InterpretasiCluster;
use App\Models\MasterIku;
use App\Models\Peta;
use App\Models\PetaAwal;
use App\Models\PetaCleaned;
use App\Models\PreprocessingPeta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ClusteringController extends Controller
{
    //

    public function index(Request $request)
    {
        $active = 6;
        $tahun  = $request->tahun;

        $clusteringRuns = ClusteringRun::when($tahun, function ($q, $tahun){
                return $q->whereYear('created_at', $tahun);
            })
            ->orderBy('created_at', 'desc') // Opsional: biar hasil rapi
            ->get(); // Jangan lupa eksekusi query!

        return view('clustering.index', compact('active', 'clusteringRuns'));
    }

public function downloadPdf($id)
{
    $clusteringRun = ClusteringRun::findOrFail($id);

    $petaCleaneds = PetaCleaned::with(['cluster.interpretasi', 'preprocessing'])
        ->where('id_clustering_run', $clusteringRun->id)
        ->orderBy('nmUnit', 'asc')
        ->get();

    // Pie Chart 1: Total Kegiatan per Cluster
    $totalPerCluster = $petaCleaneds->groupBy('cluster.cluster')
        ->map(function ($items, $cluster) {
            return $items->count();
        });

    $kegiatanLabels = $totalPerCluster->keys()->map(function ($cluster) use ($petaCleaneds) {
        $interpretasi = optional(
            $petaCleaneds->firstWhere('cluster.cluster', $cluster)->cluster->interpretasi ?? null
        )->interpretasi ?? '-';
        return 'Cluster ' . $cluster . ' - ' . $interpretasi;
    });

    $kegiatanChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
        'type' => 'pie',
        'data' => [
            'labels' => $kegiatanLabels,
            'datasets' => [[
                'data' => $totalPerCluster->values(),
                'backgroundColor' => [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 205, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                ],
            ]],
        ],
        'options' => [
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
        ],
    ]));

    // Pie Chart 2: Total IKU per Cluster
    $ikuCluster = $petaCleaneds->groupBy(fn($item) => $item->cluster !== null ? $item->cluster->cluster : 'no_cluster')
        ->map(function ($group, $key) {
            $first = $group->first();
            $clusterId = $key === 'no_cluster' ? '-' : $key;

            $ikus = $group->flatMap(function ($item) {
                if (!$item->iku) return collect([]);
                return collect(explode(',', $item->iku))->map(fn($v) => trim($v))->filter()->unique();
            })->unique();

            return [
                'cluster' => $clusterId,
                'interpretasi' => $clusterId === '-' ? '-' : optional($first->cluster->interpretasi)->interpretasi ?? '-',
                'total_iku' => $ikus->count(),
            ];
        })->values()->toArray();

    $ikuLabels = array_map(fn($item) => 'Cluster ' . $item['cluster'] . ' - ' . $item['interpretasi'], $ikuCluster);
    $ikuTotals = array_column($ikuCluster, 'total_iku');

    $ikuChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
        'type' => 'pie',
        'data' => [
            'labels' => $ikuLabels,
            'datasets' => [[
                'data' => $ikuTotals,
                'backgroundColor' => [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(255, 205, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                ],
            ]],
        ],
        'options' => [
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
        ],
    ]));

    $data = [
        'clusteringRun' => $clusteringRun,
        'petaCleaneds' => $petaCleaneds,
        'tanggal' => now()->format('d-m-Y'),
        'kegiatanChartUrl' => $kegiatanChartUrl,
        'ikuChartUrl' => $ikuChartUrl,
    ];

    $pdf = Pdf::loadView('clustering.pdf', $data)
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
        ]);

    $filename = 'Hasil_Clustering_' . $clusteringRun->nama_file . '.pdf';
    return $pdf->stream($filename);
}



    public function detail($id)
    {
        $active = 6;

        $clusteringRun = ClusteringRun::with('interpretasi')->findOrFail($id);

        // Ambil peta cleaned + relasi (kalau mau sekalian)
        $petaCleaneds = $clusteringRun->petaCleaneds()->orderBy('nmUnit', 'asc')->with(['preprocessing', 'cluster.interpretasi'])->paginate(5);

        $totalPetaRisiko = PetaCleaned::count();
        return view('clustering.detail', compact('active', 'clusteringRun', 'petaCleaneds', 'totalPetaRisiko'));
    }

    public function detailVisualisasi($id, Request $request)
    {
        $active = 6;

        $clusteringRun = ClusteringRun::with('interpretasi')->findOrFail($id);

        // Ambil daftar cluster yang digunakan
        $clusters = ClusterPeta::where('id_clustering_run', $id)
            ->select('cluster')
            ->distinct()
            ->orderBy('cluster')
            ->pluck('cluster');

        // Ambil cluster yang dipilih dari query string
        $selectedCluster = $request->has('cluster') ? $request->input('cluster') : null;

        // Build query dasar
        $query = DB::table('peta_cleaneds')
            ->join('cluster_petas', 'peta_cleaneds.id', '=', 'cluster_petas.id_peta_cleaned')
            ->where('cluster_petas.id_clustering_run', $id)
            ->select(
                'peta_cleaneds.id',
                'peta_cleaneds.iku',
                'peta_cleaneds.idUsulan',
                'cluster_petas.cluster'
            )
            ->orderBy('peta_cleaneds.id');

        // Tambahkan filter cluster jika ada
        if (!is_null($selectedCluster)) {
            $query->where('cluster_petas.cluster', $selectedCluster);
        }

        // Ambil semua data hasil query
        $petaCleanedsRaw = $query->get();

        // Ambil master IKU
        $masterIku = MasterIku::all()->keyBy('kode_iku');

        // Buat struktur data semua IKU (tanpa pagination) + idUsulan
        $ikusFull = $petaCleanedsRaw
            ->flatMap(function ($item) {
                $ikus = array_map('trim', explode(',', $item->iku));
                return collect($ikus)->map(fn($kodeIku) => [
                    'kode' => $kodeIku,
                    'idUsulan' => $item->idUsulan,
                ]);
            })
            ->groupBy('kode')
            ->map(function ($items, $kode) use ($masterIku) {
                return [
                    'uraian' => $masterIku[$kode]->uraian ?? '-',
                    'jumlah' => $items->count(),
                    'idUsulan' => $items->pluck('idUsulan')->unique()->toArray(),
                ];
            });

        // Ambil data global untuk paginasi
        $ikuGlobal = $ikusFull;

        // Ambil paginasi
        $currentPage = $request->get('page', 1);
        $perPage = 5;
        $ikuGlobalPaginated = new LengthAwarePaginator(
            $ikuGlobal->forPage($currentPage, $perPage),
            $ikuGlobal->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Per cluster (seluruh data)
        $ikusByCluster = $petaCleanedsRaw
            ->groupBy('cluster')
            ->map(function ($items) use ($masterIku) {
                return collect($items)
                    ->flatMap(function ($item) {
                        $ikus = array_map('trim', explode(',', $item->iku));
                        return collect($ikus)->map(fn($kodeIku) => [
                            'kode' => $kodeIku,
                            'idUsulan' => $item->idUsulan,
                        ]);
                    })
                    ->groupBy('kode')
                    ->map(function ($items, $kode) use ($masterIku) {
                        return [
                            'uraian' => $masterIku[$kode]->uraian ?? '-',
                            'jumlah' => $items->count(),
                            'idUsulan' => $items->pluck('idUsulan')->unique()->toArray(),
                        ];
                    });
            });

        // Jika cluster dipilih, ambil datanya untuk paginasi
        $ikusPaginated = null;
        if (!is_null($selectedCluster) && isset($ikusByCluster[$selectedCluster])) {
            $ikusClusterSelected = $ikusByCluster[$selectedCluster];
            $ikusPaginated = new LengthAwarePaginator(
                $ikusClusterSelected->forPage($currentPage, $perPage),
                $ikusClusterSelected->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        // Total untuk ditampilkan di header
        $totalIkuGlobal = $ikuGlobal->sum(fn($item) => $item['jumlah']);
        $totalIkuByCluster = $ikusByCluster->map(fn($items) => collect($items)->sum('jumlah'));

        return view('clustering.detailVisualisasi', compact(
            'active',
            'clusters',
            'selectedCluster',
            'clusteringRun',
            'ikusByCluster',
            'ikuGlobalPaginated',
            'ikuGlobal',
            'ikusPaginated',
            'ikusFull',
            'totalIkuGlobal',
            'totalIkuByCluster'
        ));
    }


    public function detailPR($id){
        $active = 6;

        $peta = PetaAwal::findOrFail($id);

        return view('clustering.detailPR', compact('active', 'peta'));
    }


    public function buatPrediksi(){
        // Menu analisis peta risiko
        $active = 6;

        $years = Peta::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('clustering.buatPrediksi', compact('active', 'years'));
    }

    public function prosesPrediksi(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    try {
        $file = $request->file('file');

        // Cek apakah nama file sudah ada di database
        $existingRun = ClusteringRun::where('nama_file', $file->getClientOriginalName())->first();
        if ($existingRun) {
            return back()->with('error', 'Nama file tersebut sudah pernah diunggah sebelumnya. Silakan gunakan file lain.');
        }

        $response = Http::attach(
            'file',
            file_get_contents($file),
            $file->getClientOriginalName()
        )->post(env('CLUSTERING_API_URL') . '/uploadFile');

        if ($response->successful()) {
            $data = $response->json();

            // Simpan informasi clustering run
            $clusteringRun = ClusteringRun::create([
                'nama_file' => $data['filename'],
                'tahun' => now()->year,
                'jumlah_cluster' => $data['clustering_run']['jumlah_cluster'],
                'silhouette_score' => $data['clustering_run']['silhouette_score'],
            ]);

            // Simpan Peta Awal
            foreach ($data['peta_awals'] as $row) {
                PetaAwal::create([
                    'id_clustering_run' => $clusteringRun->id,
                    'idUsulan' => $row['idUsulan'] ?? '',
                    'iku' => $row['kode_iku'] ?? '',
                    'nmKegiatan' => $row['nmKegiatan'] ?? '',
                    'nilRabUsulan' => $row['nilRabUsulan'] ?? '',
                    'nmUnit' => $row['nmUnit'] ?? '',
                    'pernyataanRisiko' => $row['pernyataanRisiko'] ?? '',
                    'uraianDampak' => $row['uraianDampak'] ?? '',
                    'Resiko' => $row['Resiko'] ?? '',
                    'dampak' => $row['dampak'] ?? '',
                    'probaBilitas' => $row['probaBilitas'] ?? '',
                    'pengendalian' => $row['pengendalian'] ?? '',
                ]);
            }

            // Simpan Peta Cleaned dan petakan index_cleaned ke ID-nya
            $cleanedIdMap = [];
            foreach ($data['peta_cleaneds'] as $i => $row) {
                $petaCleaned = PetaCleaned::create([
                    'id_clustering_run' => $clusteringRun->id,
                    'idUsulan' => $row['idUsulan'] ?? '',
                    'iku' => $row['kode_iku'] ?? '',
                    'nmKegiatan' => $row['nmKegiatan'] ?? '',
                    'nilRabUsulan' => $row['nilRabUsulan'] ?? '',
                    'nmUnit' => $row['nmUnit'] ?? '',
                    'pernyataanRisiko' => $row['pernyataanRisiko'] ?? '',
                    'uraianDampak' => $row['uraianDampak'] ?? '',
                    'Resiko' => $row['Resiko'] ?? '',
                    'dampak' => $row['dampak'] ?? '',
                    'probaBilitas' => $row['probaBilitas'] ?? '',
                    'pengendalian' => $row['pengendalian'] ?? '',
                ]);

                $cleanedIdMap[$i] = $petaCleaned->id;
            }

            // Simpan preprocessing
            foreach ($data['preprocessing'] as $pre) {
                $index = $pre['index_cleaned'];
                PreprocessingPeta::create([
                    'id_peta_cleaned' => $cleanedIdMap[$index],
                    'transform' => $pre['transform'],
                    'normalisasi' => $pre['normalisasi'],
                ]);
            }

            // Simpan hasil cluster
            foreach ($data['cluster_results'] as $row) {
                ClusterPeta::create([
                    'id_peta_cleaned' => $cleanedIdMap[$row['index_cleaned']],
                    'id_clustering_run' => $clusteringRun->id,
                    'cluster' => $row['cluster'],
                ]);
            }

            // Simpan interpretasi cluster
            foreach ($data['interpretasi_clusters'] as $interpret) {
                InterpretasiCluster::create([
                    'id_clustering_run' => $clusteringRun->id,
                    'cluster' => $interpret['cluster'],
                    'centroid' => $interpret['centroid'],
                    'interpretasi' => $interpret['interpretasi'],
                ]);
            }

            return redirect()->route('analisisPr.index')->with('success', 'Data berhasil disimpan');
        } else {
            return back()->with('error', 'Gagal mengirim ke API. Status: ' . $response->status());
        }
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi Error: ' . $e->getMessage());
    }
}


}
