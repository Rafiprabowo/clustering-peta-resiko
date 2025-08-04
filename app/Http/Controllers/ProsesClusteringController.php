<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProsesClusteringController extends Controller
{
    public function index(){
        $active = 25;
        return view('clustering.proses', compact('active'));
    }
}
