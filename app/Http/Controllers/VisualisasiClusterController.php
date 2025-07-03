<?php

namespace App\Http\Controllers;

use App\Models\ClusteringRun;
use App\Models\PetaCleaned;
use Illuminate\Http\Request;

class VisualisasiClusterController extends Controller
{
    public function index(Request $request)
{
    $active = 7;

    return view('analisisPR.visualisasi', compact(
        'active',
    ));
}

}
