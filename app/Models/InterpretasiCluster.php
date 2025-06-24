<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterpretasiCluster extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_clustering_run',
        'cluster',
        'centroid',
        'interpretasi',
    ];
}
