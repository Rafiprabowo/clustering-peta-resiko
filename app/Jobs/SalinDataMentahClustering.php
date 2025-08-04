<?php

namespace App\Jobs;

use App\Models\DataMentahClustering;
use App\Models\PetaRisiko;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SalinDataMentahClustering implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $datasetId;
    public $prosesId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($datasetId, $prosesId)
    {
        $this->datasetId = $datasetId;
        $this->prosesId = $prosesId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $petaRisikos = PetaRisiko::where('dataset_id', $this->datasetId)->get();

        foreach ($petaRisikos as $risiko) {
            DataMentahClustering::create([
                'proses_clustering_id' => $this->prosesId,
                'iku' => $risiko->iku,
                'id_usulan' => $risiko->id_usulan,
                'nama_kegiatan' => $risiko->nama_kegiatan,
                'nilai_rab_usulan' => $risiko->nilai_rab_usulan,
                'nama_unit' => $risiko->nama_unit,
                'resiko' => $risiko->resiko,
                'dampak' => $risiko->dampak,
                'probabilitas' => $risiko->probabilitas,
                'pernyataan_risiko' => $risiko->pernyataan_risiko,
                'uraian_dampak' => $risiko->uraian_dampak,
                'pengendalian' => $risiko->pengendalian,
            ]);
        }
    }
}
