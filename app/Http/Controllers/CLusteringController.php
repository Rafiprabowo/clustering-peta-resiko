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
            $peta->nilai_anggaran= $item['nilRabUsulan'] ?? '-';
            $peta->nama_unit= $item['nmUnit'] ?? '-';
            $peta->pernyataan_risiko= $item['pernyataanRisiko'] ?? '-';
            $peta->uraian_dampak= $item['uraianDampak'] ?? '-';
            $peta->pengendalian= $item['pengendalian'] ?? '-';
            $peta->kategori_risiko= $item['Resiko'] ?? '-';

            $peta->dampak= $item['dampak'] ?? '-';

            $peta->probabilitas= $item['probaBilitas'] ?? '-';
            $peta->status_telaah= $item['statusTelaah'] ?? '-';
            $peta->telaah_teknis = $item['telaahTeknis'] ?? '-';
            $peta->telaah_spi = $item['telaahSpi'] ?? '-';
            $peta->rekomendasi_substansi = $item['rekomendasiSubstansi'] ?? '-';
            $peta->rekomendasi_teknis = $item['rekomendasiTeknis'] ?? '-';
            $peta->rekomendasi_spi = $item['rekomendasiSpi'] ?? '-';
            $peta->rekomendasi = $item['rekomendasi'] ?? '-';
            $peta->kesesuaian_pk_direktur = $item['kesesuaianPkDirektur'] ?? '-';
            $peta->is_sesuai_pk_direktur= $item['isSesuaiPkDirektur'] ?? '-';



            // $peta->iku_angka= $item['iku_angka'] ;
            $peta->dampak_angka= $item['dampak_angka'] ?? '-';
            $peta->probabilitas_angka= $item['probaBilitas_angka'] ?? '-';
            $peta->iku_angka= $item['iku_angka'] ?? '-';

            $peta->tingkat_risiko= $item['tingkat_risiko'] ?? '-';
            $peta->nilai_iku = $item['nilai_iku'] ?? 0;
            $peta->nilai_anggaran_scaled = $item['nilRabUsulan_scaled'] ?? 0;
            $peta->tingkat_risiko_scaled = $item['tingkat_risiko_scaled'] ?? 0;
            $peta->cluster = $item['cluster'] ?? null;
            $peta->save();
        }

          // 5. Simpan centroid dan interpretasi (opsional)
        foreach ($data['centroids'] as $c) {
            $cluster = new Centroid();
            $cluster->id_clustering = $clustering->id;
            $cluster->cluster = $c['cluster'];
            $cluster->nilai_iku = $c['nilai_iku'];
            $cluster->nilai_anggaran = $c['nilai_anggaran'];
            $cluster->tingkat_risiko = $c['tingkat_risiko'];
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


}
