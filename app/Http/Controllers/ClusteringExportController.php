<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\ProsesClustering;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ClusteringExportController extends Controller
{
    public function exportPdf($prosesClusteringId)
    {
        $proses = ProsesClustering::with(['clusteredData.cleaned', 'interpretations'])
            ->findOrFail($prosesClusteringId);

        $data = collect();

        foreach ($proses->clusteredData as $row) {
            $ikus = explode(',', $row->cleaned->iku);
            $label = optional($proses->interpretations->firstWhere('cluster', $row->cluster))->label ?? 'Cluster ' . $row->cluster;

            foreach ($ikus as $iku) {
                $data->push([
                    'iku' => trim($iku),
                    'id_usulan' => $row->cleaned->id_usulan,
                    'label' => $label
                ]);
            }
        }

        $pdf = Pdf::loadView('exports.clustering-pdf', ['data' => $data->groupBy('label')]);

        return $pdf->download('hasil-clustering.pdf');
    }
}
