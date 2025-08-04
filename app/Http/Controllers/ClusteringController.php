<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClusteringController extends Controller
{
    public function index(){
        $active = 25;
        return view('clustering.index', compact('active'));
    }
}
