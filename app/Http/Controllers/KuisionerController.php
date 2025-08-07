<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KuisionerController extends Controller
{
    public function index(){
        $active = 23;
        return view('clustering.kuisioner', compact('active'));
    }
}
