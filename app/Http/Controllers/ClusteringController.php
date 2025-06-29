<?php

namespace App\Http\Controllers;

use App\Models\ClusteringRun;
use App\Models\ClusterLabel;
use App\Models\ClusterPeta;
use App\Models\InterpretasiCluster;
use App\Models\MasterIku;
use App\Models\Peta;
use App\Models\PetaAwal;
use App\Models\PetaCleaned;
use App\Models\PetaRisikoCluster;
use App\Models\PetaRisikoFile;
use App\Models\PetaRisikoMentah;
use App\Models\PetaRisikoProcessing;
use App\Models\PetaRisikoTransformed;
use App\Models\PreprocessingPeta;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\Continue_;

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



    public function detail($id)
    {
        $active = 6;

        $clusteringRun = ClusteringRun::findOrFail($id);

        // Ambil peta awal dengan pagination
        $petaAwals = $clusteringRun->petaAwals()->paginate(5);

        // Ambil peta cleaned + relasi (kalau mau sekalian)
        $petaCleaneds = $clusteringRun->petaCleaneds()->with(['preprocessing', 'cluster.interpretasi'])->get();

        return view('clustering.detail', compact('active', 'clusteringRun', 'petaAwals', 'petaCleaneds'));
    }





    public function detailPR($id){
        $active = 6;

        $peta = PetaAwal::findOrFail($id);

        return view('clustering.detailPR', compact('active', 'peta'));
    }

    public function detailCleanedPR($id){
        $active = 6;

        $peta = PetaCleaned::findOrFail($id);

        return view('clustering.detailCleanedPR', compact('active', 'peta'));
    }

     public function detailTransform($id){
        $active  = 6;
        $petaRisiko = PetaRisikoMentah::with('transformed')->findOrFail($id);

        return view('clustering.detailTransformPeta', compact('active', 'petaRisiko'));
    }

    public function detailProcessingPeta($id){
        $active  = 6;
        $petaRisiko = PetaRisikoMentah::with('processing')->findOrFail($id);

        return view('clustering.detailProcessingPeta', compact('active', 'petaRisiko'));
    }

    public function detailPetaMentahById($id){
        $active = 6;

        $petaRisiko = PetaRisikoMentah::with('processing')->findOrFail($id);

        return view('clustering.detailPetaRisikoById', compact('active', 'petaRisiko'));

    }

    public function showPetaRisikoMentah(Request $request){
        $active = 6;

        $selectedYear = $request->input('year');
        $selectedFile = $request->get('file');

        $years = PetaRisikoMentah::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $fileNames = PetaRisikoFile::pluck('nama_file');

        $fileId = null;
        if ($selectedFile){
            $fileId = PetaRisikoFile::where('nama_file', $selectedFile)->value('id');
        }


        $query = PetaRisikoMentah::select('nmUnit', DB::raw('YEAR(created_at) as tahun'), DB::raw('COUNT(*) as total'))
            ->when($selectedYear, function($q) use ($selectedYear){
                return $q->whereYear('created_at', $selectedYear);
            })
            ->when($fileId, function ($q) use ($fileId){
                return $q->where('id_file_peta_risiko', $fileId);
            })
            ->groupBy('nmUnit', DB::raw('YEAR(created_at)'))
            ->orderBy('nmUnit')
            ->orderBy(DB::raw('YEAR(created_at)'), 'desc');


        $results = $query->get();

        $perPage = 5;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;

        $itemsForCurrentPage = $results->slice($offset, $perPage)->values();

        $unitKerjas =  new LengthAwarePaginator(
            $itemsForCurrentPage,
            $results->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('clustering.petaRisikoMentah', compact('active', 'unitKerjas', 'years', 'fileNames' ,'selectedYear', 'selectedFile'));
    }

    public function showDetailPetaRisikoMentah($unit, $tahun){
        $active = 6;

        // Decode nama unit yang dikirim via URL
        $decodedUnit = urldecode($unit);

        $petaRisikos = PetaRisikoMentah::with('processing')
        ->where('nmUnit', $decodedUnit)
        ->whereYear('created_at', $tahun)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('clustering.detailPetaRisikoMentah', compact('active', 'decodedUnit', 'tahun', 'petaRisikos'));
    }


    public function buatPrediksi(){
        // Menu analisis peta risiko
        $active = 6;

        $years = Peta::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('clustering.buatPrediksi', compact('active', 'years'));
    }

    public function prosesPrediksi(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',

        ]);

            try{
                $file = $request->file('file');

                $response = Http::attach('file', file_get_contents($file), $file->getClientOriginalName())->post('http://localhost:8001/uploadFile');

                if($response->successful()){
                    $data = $response->json();

                    $clusteringRun = ClusteringRun::create([
                        'nama_file' => $data['filename'],
                        'tahun' => now()->year,
                        'jumlah_cluster' => $data['clustering_run']['jumlah_cluster'],
                        'silhouette_score' => $data['clustering_run']['silhouette_score']
                    ]);


                    foreach($data['peta_awals'] as $row){
                        $petaAwal = PetaAwal::create([
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
                            'pengendalian' => $row['pengendalian'] ?? ''
                        ]);

                    }

                    foreach($data['peta_cleaneds'] as $row){
                        PetaCleaned::create([
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
                            'pengendalian' => $row['pengendalian'] ?? ''
                        ]);
                    }

                    $cleanedIds = PetaCleaned::latest()->take(count($data['peta_cleaneds']))->pluck('id')->reverse()->values();

                    foreach ($data['preprocessing'] as $i => $pre) {
                        PreprocessingPeta::create([
                            'id_peta_cleaned' => $cleanedIds[$i],
                            'transform' => json_encode($pre['transform']),
                            'normalisasi' => json_encode($pre['normalisasi'])
                        ]);
                    }



                    foreach ($data['cluster_results'] as $i => $row) {
                        ClusterPeta::create([
                            'id_peta_cleaned' => $cleanedIds[$row['index_cleaned']],
                            'id_clustering_run' => $clusteringRun->id,
                            'cluster' => $row['cluster']
                        ]);
                    }

                    foreach ($data['interpretasi_clusters'] as $interpret) {
                        InterpretasiCluster::create([
                            'id_clustering_run' => $clusteringRun->id,
                            'cluster' => $interpret['cluster'],
                            'centroid' => json_encode($interpret['centroid']),
                            'interpretasi' => $interpret['interpretasi']
                        ]);
                    }

                    return redirect()->route('analisisPr.index')->with('success', 'Data berhasil disimpan');

                }else{
                    return back()->with('error', 'Gagal mengirim ke API. Status: ' . $response->status());
                }
            }catch(\Exception $e){
                return back()->with('error', 'Terjadi Error: '. $e->getMessage());
            }


    }
}
