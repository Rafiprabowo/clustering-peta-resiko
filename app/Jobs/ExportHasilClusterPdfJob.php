<?php

namespace App\Jobs;

use App\Models\Clustering;
use App\Models\ClusterPetaRisiko;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ExportClusterPdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $clusteringId;
    public $userId;

    public function __construct($clusteringId, $userId)
    {
        $this->clusteringId = $clusteringId;
        $this->userId = $userId;
    }

    public function handle()
    {
        $data = ClusterPetaRisiko::where('id_clustering', $this->clusteringId)->get();
        $namaFile = Clustering::find($this->clusteringId)?->nama_file ?? 'Data Clustering';

        $pdf = Pdf::loadView('exports.hasil-cluster-pdf', [
            'data' => $data,
            'namaFile' => $namaFile,
        ]);

        $filename = 'pdf_exports/data_clustering_' . $this->clusteringId . '_' . now()->timestamp . '.pdf';

        Storage::put($filename, $pdf->output());

        // Notifikasi bisa dikirim ke user jika mau
        // User::find($this->userId)->notify(new PdfReadyNotification($filename));
    }
}
