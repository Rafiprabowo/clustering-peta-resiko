<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatClusteringController extends Controller
{
    public function index(){
        $active = 26;
        return view('clustering.riwayat', compact('active'));
    }
}
