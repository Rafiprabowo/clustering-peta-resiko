<?php

namespace App\Http\Controllers;

use App\Models\ImportedDataset;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function index(){
        $datasets = ImportedDataset::all();

        
    }
}
