<?php

namespace App\Imports;

use App\Models\ImportedDataset;
use App\Models\PetaRisiko;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatasetPetaRisikoImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $namaFile;

    public function __construct($namaFile) {
        $this->namaFile = $namaFile;
    }

    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            PetaRisiko::create([
                'nama_file' => $this->namaFile,
                'iku' => $row['iku'] ?? null,
                'id_usulan' => $row['idusulan'] ?? null ,
                'nama_kegiatan' => $row['nmkegiatan'] ?? null,
                'nilai_rab_usulan' => $row['nilrabusulan'] ?? null,
                'nama_unit' => $row['nmunit'] ?? null,
                'pernyataan_risiko' => $row['pernyataanrisiko'] ?? null,
                'uraian_dampak' => $row['uraiandampak'] ?? null,
                'pengendalian' => $row['pengendalian'] ?? null,
                'risiko' => $row['resiko'] ?? null,
                'dampak' => $row['dampak'] ?? null,
                'probabilitas' => $row['probabilitas'] ?? null,
            ]);
        }

         // Simpan riwayat
        ImportedDataset::create([
            'nama_file' => $this->namaFile,
            'jumlah_data' => $rows->count(),
            'uploaded_at' => now(),
        ]);
    }
}
