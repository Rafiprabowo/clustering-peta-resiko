<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaAwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_clustering_run',
        'idUsulan',
        'iku',
        'nmKegiatan',
        'nilRabUsulan',
        'nmUnit',
        'pernyataanRisiko',
        'uraianDampak',
        'pengendalian',
        'Resiko',
        'dampak',
        'probaBilitas',
    ];

}
