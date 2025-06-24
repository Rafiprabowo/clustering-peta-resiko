<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClusterPeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_peta_cleaned',
        'id_clustering_run',
        'cluster'
    ];


    public function run(){
        return $this->belongsTo(ClusteringRun::class, 'id_clustering_run');
    }

    public function cleaned(){
        return $this->belongsTo(PetaCleaned::class, 'id_peta_cleaned');
    }

    public function interpretasi(){
        return $this->hasOne(InterpretasiCluster::class, 'cluster', 'cluster')
            ->whereColumn('id_clustering_run', 'id_clustering_run');
    }
}
