<?php

use App\Http\Controllers\AnalisisPetaRisikoController;
use App\Http\Controllers\CLusteringController;
use App\Http\Controllers\PetaRisikoController;
use App\Http\Controllers\ProsesClusteringController;
use App\Models\Clustering;
use Illuminate\Support\Facades\Route;




// dataset-clustering

Route::prefix('/dataset')->group(function(){
    Route::get('/', [PetaRisikoController::class, 'riwayat'])->name('datasetPetaRisiko.riwayat')->middleware('auth');
    Route::get('/import', [PetaRisikoController::class, 'formImport'])->name('datasetPetaRisiko.import.form')->middleware('auth');
    Route::post('/import', [PetaRisikoController::class, 'import'])->name('datasetPetaRisiko.import')->middleware('auth');
    Route::get('/edit/{id}', [PetaRisikoController::class, 'edit'])->name('datasetPetaRisiko.edit')->middleware('auth');
    Route::post('/update/{id}', [PetaRisikoController::class, 'update'])->name('datasetPetaRisiko.update')->middleware('auth');
    Route::post('/delete-by-filename', [PetaRisikoController::class, 'deleteByFile'])->name('datasetPetaRisiko.delete.byfilename');
    Route::get('/export/{nama_file}', [PetaRisikoController::class, 'export'])->name('datasetPetaRisiko.export');
});

Route::prefix('/proses')->group(function(){
    Route::get('/', [ProsesClusteringController::class, 'index'])->name('prosesClustering.index')->middleware('auth');
});



// analisis-peta-risiko
Route::get('/analisis-peta-risiko', [AnalisisPetaRisikoController::class, 'index'])->name('analisis-peta-risiko.index')->middleware('auth');



// proses-clustering
Route::get('/proses', [CLusteringController::class, 'proses'])->name('clustering.proses')->middleware('auth');


// riwayat-clustering
Route::get('/riwayat', [CLusteringController::class, 'riwayat'])->name('clustering.riwayat')->middleware('auth');
Route::delete('/riwayat/{id}', [CLusteringController::class, 'destroy'])->name('clustering.delete')->middleware('auth');

Route::get('/kuisioner', function (){
    return view('clustering.kuisioner');
});

Route::get('/manual-book', function (){
    return view('clustering.manualBook');
});
