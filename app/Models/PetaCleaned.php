<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaCleaned extends Model
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

    public function clusteringRun(){
        return $this->belongsTo(ClusteringRun::class, 'id_clustering_run');
    }

    public function cluster(){
        return $this->hasOne(ClusterPeta::class, 'id_peta_cleaned');
    }

    public function preprocessing(){
        return $this->hasOne(PreprocessingPeta::class, 'id_peta_cleaned');
    }

}
