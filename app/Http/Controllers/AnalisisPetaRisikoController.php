<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalisisPetaRisikoController extends Controller
{
    public function index(){
        $active = 21;
        return view('analisisPeta.index', compact('active'));
    }
}
