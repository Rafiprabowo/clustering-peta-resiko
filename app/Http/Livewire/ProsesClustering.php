<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ImportedDataset;
use App\Models\InterpretasiCluster;
use App\Models\PetaCleaned;
use App\Models\PetaClustering;
use App\Models\PetaRisiko;
use App\Models\PetaTransform;
use App\Models\PetaNormalize;
use Illuminate\Support\Facades\Http;

class ProsesClustering extends Component
{
    use WithPagination;
    protected $fieldCleaning = [
        'iku', 'id_usulan', 'nama_kegiatan', 'nilai_rab_usulan', 'nama_unit', 'pernyataan_risiko', 'uraian_dampak', 'pengendalian', 'risiko', 'dampak', 'probabilitas'
    ];

    protected $fieldTransform = [
        'iku', 'id_usulan', 'nama_kegiatan', 'nilai_rab_usulan', 'nama_unit', 'pernyataan_risiko', 'uraian_dampak', 'pengendalian', 'risiko', 'dampak', 'probabilitas'
    ];

    protected $fieldNormalize = [
        'iku', 'id_usulan', 'nama_kegiatan', 'nilai_rab_usulan', 'nama_unit', 'pernyataan_risiko', 'uraian_dampak', 'pengendalian', 'risiko', 'dampak', 'probabilitas'
    ];


    protected $paginationTheme = 'bootstrap';

    public $tahunList = [];
    public $tahunTerpilih = null;

    public $step = 'awal'; // ['awal', 'cleaning', 'transform', 'normalize', 'cluster']

    public $daftarFile = [];
    public $namaFileTerpilih = null;

    public function mount()
    {
        $this->tahunList = ImportedDataset::query()
            ->selectRaw('YEAR(uploaded_at) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();
    }

    public function updatedTahunTerpilih($value)
    {
        $this->reset('namaFileTerpilih');
        $this->daftarFile = ImportedDataset::whereYear('uploaded_at', $value)
            ->pluck('nama_file')
            ->toArray();
    }

    public function updatingNamaFileTerpilih()
    {
        $this->resetPage();
        $this->step = 'awal';
    }



    public function prosesCleaning()
    {
        if (!$this->namaFileTerpilih) return;

        // Ambil data dari tabel peta_risikos untuk dikirim
        $dataMentah = PetaRisiko::where('nama_file', $this->namaFileTerpilih)->select($this->fieldCleaning)->get()->toArray();

        try {
            $response = Http::post('http://127.0.0.1:8001/cleaning', [
                'nama_file' => $this->namaFileTerpilih,
                'data' => $dataMentah,
            ]);

            if ($response->successful()) {
                $hasil = $response->json();

                // Bersihkan data cleaned sebelumnya (optional)
                PetaCleaned::where('nama_file', $this->namaFileTerpilih)->delete();

                // Simpan hasil baru
                foreach ($hasil['data'] as $row) {
                    $cleaned = new PetaCleaned($row);
                    $cleaned->nama_file = $this->namaFileTerpilih;
                    $cleaned->save();
                }

                $this->step = 'cleaning';
                session()->flash('success', 'Proses cleaning berhasil!');
            } else {
                session()->flash('error', 'Gagal memproses data: ' . $response->body());
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi error: ' . $e->getMessage());
        }
    }





    public function prosesTransform()
    {
        if (!$this->namaFileTerpilih) return;

        // Ambil data dari cleaned
        $dataCleaned = PetaCleaned::where('nama_file', $this->namaFileTerpilih)
            ->select($this->fieldTransform)
            ->get()
            ->toArray();

        try {
            $response = Http::post('http://127.0.0.1:8001/transform', [
                'nama_file' => $this->namaFileTerpilih,
                'data' => $dataCleaned,
            ]);

            if ($response->successful()) {
                $hasil = $response->json();

                // Hapus data transform sebelumnya
                PetaTransform::where('nama_file', $this->namaFileTerpilih)->delete();

                foreach ($hasil['data'] as $row) {
                    $transformed = new PetaTransform($row);
                    $transformed->nama_file = $this->namaFileTerpilih;
                    $transformed->save();
                }

                $this->step = 'transform';
                session()->flash('success', 'Proses transform berhasil!');
            } else {
                session()->flash('error', 'Gagal transformasi: ' . $response->body());
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi error: ' . $e->getMessage());
        }
    }



    public function prosesNormalize()
    {
        if (!$this->namaFileTerpilih) return;

        $dataToSend = PetaTransform::where('nama_file', $this->namaFileTerpilih)
            ->select($this->fieldNormalize)
            ->get()
            ->toArray();

        try {
            $response = Http::post('http://127.0.0.1:8001/normalize', [
                'nama_file' => $this->namaFileTerpilih,
                'data' => $dataToSend,
            ]);

            if ($response->successful()) {
                $hasil = $response->json();

                PetaNormalize::where('nama_file', $this->namaFileTerpilih)->delete();

                foreach ($hasil['data'] as $row) {
                    $row['nama_file'] = $this->namaFileTerpilih;
                    $model = new PetaNormalize($row);
                    $model->save();
                }

                $this->step = 'normalize';
                session()->flash('success', 'Proses normalisasi berhasil!');
            } else {
                session()->flash('error', 'Gagal memproses normalisasi: ' . $response->body());
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi error: ' . $e->getMessage());
        }
    }

    public function prosesClustering()
    {
        if (!$this->namaFileTerpilih) return;

        $data = PetaNormalize::where('nama_file', $this->namaFileTerpilih)
            ->select('id_usulan', 'nama_kegiatan', 'iku', 'nilai_rab_usulan', 'tingkat_risiko')
            ->get()
            ->map(function ($item) {
                return [
                    'id_usulan' => $item->id_usulan,
                    'nama_kegiatan' => $item->nama_kegiatan,
                    'iku' => floatval($item->iku),
                    'nilai_rab_usulan' => floatval($item->nilai_rab_usulan),
                    'tingkat_risiko' => floatval($item->tingkat_risiko),
                ];
            })
            ->toArray();

        try {
            $response = Http::post('http://127.0.0.1:8001/clustering', [
                'data' => $data,
            ]);

            if ($response->successful()) {
                $hasil = $response->json();

                // Hapus data lama
                PetaClustering::where('nama_file', $this->namaFileTerpilih)->delete();
                InterpretasiCluster::where('nama_file', $this->namaFileTerpilih)->delete();

                // Simpan hasil clustering
                foreach ($hasil['data'] as $index => $row) {
                    try {
                        PetaClustering::create([
                            'nama_file' => $this->namaFileTerpilih,
                            'id_usulan' => $row['id_usulan'],
                            'nama_kegiatan' => $row['nama_kegiatan'],
                            'iku' => $row['iku'],
                            'nilai_rab_usulan' => $row['nilai_rab_usulan'],
                            'tingkat_risiko' => $row['tingkat_risiko'],
                            'cluster' => $row['cluster'],
                        ]);
                    } catch (\Exception $e) {
                        dd("Gagal simpan di row $index", $row, $e->getMessage());
                    }
                }


                // Simpan interpretasi centroid
                foreach ($hasil['centroids'] as $centroid) {
                    InterpretasiCluster::create([
                        'nama_file' => $this->namaFileTerpilih,
                        'cluster' => $centroid['cluster'],
                        'c_iku' => $centroid['c_iku'],
                        'c_anggaran' => $centroid['c_anggaran'],
                        'c_tingkat_risiko' => $centroid['c_tingkat_risiko'],
                        'interpretasi' => $centroid['interpretasi'],
                        'tingkat_prioritas' => $centroid['tingkat_prioritas'],
                    ]);
                }

                $this->step = 'cluster';
                session()->flash('success', 'Proses clustering berhasil!');
            } else {
                session()->flash('error', 'Gagal clustering: ' . $response->body());
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }


    public function getDataTableProperty()
    {
        if (!$this->namaFileTerpilih) return collect();

        return match ($this->step) {
            'cleaning'  => PetaCleaned::where('nama_file', $this->namaFileTerpilih)->paginate(1),
            'transform' => PetaTransform::where('nama_file', $this->namaFileTerpilih)->paginate(1),
            'normalize' => PetaNormalize::where('nama_file', $this->namaFileTerpilih)->paginate(1),
            'cluster' => PetaClustering::where('nama_file', $this->namaFileTerpilih)->paginate(1),
            default     => PetaRisiko::where('nama_file', $this->namaFileTerpilih)->paginate(1),
        };
    }

    public function render()
    {
        return view('livewire.proses-clustering', [
            'dataTable' => $this->dataTable, // GANTI 'dataAwal' → 'dataTable'
        ]);
    }

}
