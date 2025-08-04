<?php

namespace App\Imports;

use App\Models\PetaRisiko;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatasetPetaRisikoImport implements ToCollection, WithHeadingRow
{
    protected $datasetId;

    public function __construct($datasetId)
    {
        $this->datasetId = $datasetId;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Daftar IKU yang tersedia
            $ikuItems = ['IKU 1.1', 'IKU 1.2', 'IKU 2', 'IKU 3', 'IKU 5', 'IKU 6', 'IKU 8', 'IKU 8.1', 'IKU 9', 'IKU 9.1', 'IKU 10', 'IKU 11', ''];

            // Ambil jumlah acak antara 1 hingga 4 (jumlah maksimum dari item IKU)
            $randomCount = rand(1, 4);

            // Ambil IKU secara acak tanpa duplikat
            $selectedIku = collect($ikuItems)->shuffle()->take($randomCount)->implode(', ');

            PetaRisiko::create([
                'dataset_id' => $this->datasetId,
                'iku' => $row['iku'] ?? $selectedIku,
                'id_usulan' => $row['idusulan'] ?? null,
                'nama_kegiatan' => $row['nmkegiatan'] ?? null,
                'nilai_rab_usulan' => $row['nilrabusulan'] ?? null,
                'nama_unit' => $row['nmunit'] ?? null,
                'resiko' => $row['resiko'] ?? null,
                'dampak' => $row['dampak'] ?? null,
                'probabilitas' => $row['probabilitas'] ?? null,
                'pernyataan_risiko' => $row['pernyataanrisiko'] ?? null,
                'uraian_dampak' => $row['uraiandampak'] ?? null,
                'pengendalian' => $row['pengendalian'] ?? null,
            ]);
        }
    }
}
