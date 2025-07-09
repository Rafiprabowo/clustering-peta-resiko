<?php

use App\Http\Controllers\AnalisisPetaRisikoController;
use App\Http\Controllers\CLusteringController;
use Illuminate\Support\Facades\Route;

Route::get('/clustering-peta-risiko', function (){
     $active = 20;
    return view('clustering.create-prediksi', compact('active'));
})->name('buatPrediksi')->middleware('auth');


Route::post('/clustering-peta-risiko', [CLusteringController::class, 'proses'])->name('clustering.proses')->middleware('auth');
Route::get('/riwayat-clustering', [CLusteringController::class, 'riwayat'])->name('clustering.riwayat')->middleware('auth');
Route::delete('/riwayat-clustering/{id}', [CLusteringController::class, 'destroy'])->name('clustering.delete')->middleware('auth');

Route::get('/hasil-cluster', [CLusteringController::class, 'hasilCluster'])->name('clustering.hasilCluster')->middleware('auth');

Route::get('/analisis-peta-risiko', [AnalisisPetaRisikoController::class, 'index'])->name('analisis-peta-risiko.index')->middleware('auth');

// Route::prefix('riwayat-clustering')->group(function(){
//     Route::get('/', function (){
//         $active = 21;
//         $clusteringRuns = C::all();
//         return view('clustering.index', compact('active', 'clusteringRuns'));
//     })->name('riwayat-clustering.index');
// });

// Route::prefix('clusters')->group(function(){
//     Route::get('/', function(){
//         $active = 22;
//         return view('clustering.hasilCluster', compact('active'));
//     });
// });

// Route::prefix('analisis-peta-risiko')->group(function(){
//     Route::get('/', function (){
//         $active = 23;
//         return view('analisisPR.dashboard', compact('active'));
//     });
// });
