<?php

namespace App\Http\Controllers;

use App\Models\Centroid;
use App\Models\Clustering;
use App\Models\ClusterPetaRisiko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CLusteringController extends Controller
{
    //create clustering
    public function create(){
        return view('clustering.create-prediksi');
    }
    //store clustering
    public function store(Request $request){

         // 1. Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        // 2. Kirim file ke API FastAPI
        $response = Http::attach(
            'file',
            file_get_contents($file),
            $file->getClientOriginalName()
        )->post('http://127.0.0.1:8001/uploadFile');

        if (!$response->successful()) {
            return back()->with('error', 'Gagal mengirim file ke API');
        }

        $data = $response->json();

        $namaFile = $data['nama_file'] ?? $file->getClientOriginalName();
        $existing = Clustering::where('nama_file', $namaFile)->first();

        if ($existing) {
            return back()->with('error', 'File dengan nama tersebut sudah pernah diunggah.');
        }

        $clustering = new Clustering();
        $clustering->nama_file = $namaFile;
        $clustering->total_data = $data['total_data'];
        $clustering->data_bersih = $data['data_bersih'];
        $clustering->data_dibuang = $data['data_dibuang'];
        $clustering->score = $data['score'];
        $clustering->save();


        // 4. Simpan data hasil clustering ke DB (misal tabel `peta_risiko`)
        foreach ($data['data'] as $item) {
            $peta = new ClusterPetaRisiko();
            $peta->id_clustering = $clustering->id;
            $peta->id_usulan = $item['idUsulan'] ?? '-';
            $peta->iku = $item['iku'] ?? '-';
            $peta->nama_kegiatan= $item['nmKegiatan'] ?? '-';
            $peta->nil_rab_usulan= $item['nilRabUsulan'] ?? 0;
            $peta->nama_unit= $item['nmUnit'] ?? '-';
            $peta->pernyataan_risiko= $item['pernyataanRisiko'] ?? '-';
            $peta->uraian_dampak= $item['uraianDampak'] ?? '-';
            $peta->pengendalian= $item['pengendalian'] ?? '-';
            $peta->kategori_risiko= $item['Resiko'] ?? '-';

            $peta->dampak= $item['dampak'] ?? 0;

            $peta->probabilitas= $item['probaBilitas'] ?? 0;
            $peta->status_telaah= $item['statusTelaah'] ?? 0;
            $peta->telaah_teknis = $item['telaahTeknis'] ?? 0;
            $peta->telaah_spi = $item['telaahSpi'] ?? 0;
            $peta->rekomendasi_substansi = $item['rekomendasiSubstansi'] ?? '-';
            $peta->rekomendasi_teknis = $item['rekomendasiTeknis'] ?? '-';
            $peta->rekomendasi_spi = $item['rekomendasiSpi'] ?? '-';
            $peta->rekomendasi = $item['rekomendasi'] ?? '-';
            $peta->kesesuaian_pk_direktur = $item['kesesuaianPkDirektur'] ?? '-';
            $peta->is_sesuai_pk_direktur= $item['isSesuaiPkDirektur'] ?? '-';
            $peta->tingkat_risiko= $item['tingkat_risiko'] ?? 0;

            // transform
            $peta->dampak_numerik= $item['dampak_numerik'] ?? 0;
            $peta->probabilitas_numerik= $item['probabilitas_numerik'] ?? 0;
            $peta->iku_numerik= $item['iku_numerik'] ?? 0;

            //normalisasi
            $peta->normal_iku_numerik = $item['normal_iku_numerik'] ?? 0;
            $peta->normal_nil_rab_usulan = $item['normal_nilRabUsulan'] ?? 0;
            $peta->normal_tingkat_risiko = $item['normal_tingkat_risiko'] ?? 0;
            $peta->cluster = $item['cluster'] ?? null;
            $peta->save();
        }

          // 5. Simpan centroid dan interpretasi (opsional)
        foreach ($data['centroids'] as $c) {
            $cluster = new Centroid();
            $cluster->id_clustering = $clustering->id;
            $cluster->cluster = $c['cluster'];
            $cluster->c_iku = $c['c_iku'];
            $cluster->c_nil_rab_usulan = $c['c_nilRabUsulan'];
            $cluster->c_tingkat_risiko = $c['c_tingkat_risiko'];
            $cluster->save();
        }

        return back()->with('success', 'Data berhasil diproses dan disimpan.');

    }


    public function destroy($id)
    {
        $riwayat = Clustering::find($id);
        if (!$riwayat) {
            return back()
                ->with('error', 'Data clustering tidak ditemukan.');
        }

        $riwayat->delete();

        return back()
            ->with('success', 'Data clustering berhasil dihapus!');
    }

    public function riwayat(){
        $riwayats = Clustering::paginate(10);
        return view('clustering.riwayat-clustering', compact('riwayats'));
    }

    public function hasilCluster(){
        return view('clustering.hasil-cluster');
    }

    public function proses()
    {
        return view('clustering.proses-clustering');
    }










}
