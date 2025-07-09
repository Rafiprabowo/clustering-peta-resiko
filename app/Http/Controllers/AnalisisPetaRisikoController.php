<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalisisPetaRisikoController extends Controller
{
    public function index(){
        return view('clustering.analisis-peta-risiko');
    }
}
