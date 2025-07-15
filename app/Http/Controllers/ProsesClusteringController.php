<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProsesClusteringController extends Controller
{
    public function index(){
        return view('clustering.proses.proses');
    }
}
