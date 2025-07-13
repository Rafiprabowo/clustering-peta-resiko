<?php

use App\Http\Controllers\AnalisisPetaRisikoController;
use App\Http\Controllers\CLusteringController;
use App\Http\Controllers\ProsesClusteringController;
use App\Models\Clustering;
use Illuminate\Support\Facades\Route;

// analisis-peta-risiko
Route::get('/analisis-peta-risiko', [AnalisisPetaRisikoController::class, 'index'])->name('analisis-peta-risiko.index')->middleware('auth');


// dataset-clustering
Route::get('/dataset', [CLusteringController::class, 'create'])->name('clustering.create')->middleware('auth');
Route::post('/dataset', [CLusteringController::class, 'store'])->name('clustering.store')->middleware('auth');
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
