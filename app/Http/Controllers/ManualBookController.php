<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManualBookController extends Controller
{
    public function index(){
        $active = 22;
        return view('clustering.manual-book', compact('active'));
    }

    public function download(){
        $filePath = public_path('manual/manual-book.pdf');

        // Pastikan file ada
        if (file_exists($filePath)) {
            return response()->download($filePath, 'Manual-Book.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        }

        // Jika file tidak ditemukan
        abort(404, 'Manual book tidak ditemukan.');
    }
}
